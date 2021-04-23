<?php

namespace App\Modules\Features\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class FeatureDestroyForFrontendRequest
 *
 * @package App\Modules\Features\Requests
 */
class FeatureDestroyForFrontendRequest extends FormRequest implements RequestInterface
{
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
        return [
            'feature_id' => ['required', 'integer', Rule::exists('features')],
            'value' => ['required', 'integer'],
        ];
    }
    
    public function attributes()
    {
        return [
            'feature_id' => trans('features::general.feature'),
            'value' => trans('features::admin.current-value'),
        ];
    }

}
