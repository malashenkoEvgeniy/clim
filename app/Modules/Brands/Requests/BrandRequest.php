<?php

namespace App\Modules\Brands\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Exceptions\WrongParametersException;
use App\Modules\Brands\Models\Brand;
use App\Modules\Brands\Models\BrandTranslates;
use App\Rules\MultilangSlug;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BrandRequest
 *
 * @package App\Modules\Brands\Requests
 */
class BrandRequest extends FormRequest implements RequestInterface
{
    use ValidationRulesTrait;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws WrongParametersException
     */
    public function rules(): array
    {
        /** @var Brand $brand */
        $brand = $this->route('brand');
        
        return $this->generateRules([
            'active' => ['required', 'bool'],
        ], [
            'name' => ['required', 'max:191'],
            'slug' => ['required', new MultilangSlug(
                (new BrandTranslates())->getTable(),
                null,
                $brand->id ?? null
            )],
        ]);
    }
    
}
