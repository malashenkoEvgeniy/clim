<?php

namespace App\Modules\Features\Requests;

use App\Core\BaseRequest;
use App\Modules\Features\Models\Feature;
use App\Modules\Features\Rules\FeatureValueMultilangSlug;
use App\Modules\Features\Models\FeatureValue;
use App\Traits\ValidationRulesTrait;
use Config;

/**
 * Class FeatureValueRequest
 *
 * @package App\Modules\Features\Requests
 */
class FeatureValueRequest extends BaseRequest
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
     */
    public function rules(): array
    {
        /** @var FeatureValue $value */
        $value = $this->route('value');
        /** @var Feature $feature */
        $feature = $this->route('feature');
        
        $attributes = [];
        foreach (config('languages', []) as $slug => $language) {
            $attributes[$slug . '.slug'] = [
                'required',
                new FeatureValueMultilangSlug($slug, $feature->id ?? null, $value->id ?? null),
            ];
        }
        return $this->generateRules($attributes, [
            'name' => ['required', 'max:191'],
        ]);
    }
    
    /**
     * @return array
     */
    public function attributes()
    {
        return $this->makeAttributes([
            'name' => trans('validation.attributes.name'),
            'slug' => trans('validation.attributes.slug'),
        ]);
    }

}
