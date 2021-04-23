<?php

namespace App\Modules\Products\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Brands\Rules\IsBrand;
use App\Modules\Categories\Rules\CategoryExists;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class GroupFrontendRequest
 *
 * @package App\Modules\Products\Requests
 */
class GroupFrontendRequest extends FormRequest implements RequestInterface
{
    use ValidationRulesTrait;
    
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return $this->generateRules([
            'category_id' => ['required', new CategoryExists],
            'brand_id' => ['nullable', new IsBrand],
            'position' => ['required', 'integer'],
            
            'modification.price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'modification.old_price' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'modification.value_id' => ['required', 'integer'],
            'modification.vendor_code' => ['nullable', 'string', 'max:191'],
            'modification.available' => ['required', Rule::in(array_keys(config('products.availability', [])))],
        ], [
            'name' => ['required', 'max:191'],
            
            'modification.name' => ['nullable', 'max:191'],
            'modification.slug' => ['nullable', 'max:191'],
        ]);
    }
    
    public function attributes()
    {
        $attributes = [
            'modification.available' => trans('validation.attributes.available'),
            'modification.value' => trans('products::admin.attributes.modification-value'),
        ];
        foreach (config('languages', []) as $slug => $language) {
            $attributes += [
                $slug . '.modification.name' => trans('validation.attributes.name'),
                $slug . '.modification.slug' => trans('validation.attributes.slug'),
                $slug . '.modification.h1' => trans('validation.attributes.h1'),
                $slug . '.modification.title' => trans('validation.attributes.title'),
                $slug . '.modification.description' => trans('validation.attributes.description'),
                $slug . '.modification.keywords' => trans('validation.attributes.keywords'),
            ];
        }
        return $attributes;
    }
    
}
