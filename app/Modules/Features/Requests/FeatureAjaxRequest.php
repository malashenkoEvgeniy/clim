<?php

namespace App\Modules\Features\Requests;

use App\Core\BaseRequest;
use App\Modules\Features\Models\Feature;
use App\Rules\MultilangSlug;
use App\Modules\Features\Models\FeatureTranslates;
use App\Traits\ValidationRulesTrait;
use Illuminate\Validation\Rule;
use Config;

/**
 * Class FeatureAjaxRequest
 *
 * @package App\Modules\Features\Requests
 */
class FeatureAjaxRequest extends BaseRequest
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
     * @throws \App\Exceptions\WrongParametersException
     */
    public function rules(): array
    {
        /** @var Feature $feature */
        $feature = $this->route('features');

        return $this->generateRules([
            'features-in_filter' => ['required', 'bool'],
            'features-type' => ['required', Rule::in(array_keys(config('features.types', [])))],
        ], [
            'name' => ['required', 'max:191'],
            'slug' => ['required', new MultilangSlug(
                (new FeatureTranslates())->getTable(),
                null,
                $feature->id ?? null
            )],
        ]);
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        foreach (Config::get('languages') as $key => $lang) {
            $attributes = [
                $key.'features-name' => trans('validation.attributes.name'),
            ];
        }
        return $attributes;
    }

}
