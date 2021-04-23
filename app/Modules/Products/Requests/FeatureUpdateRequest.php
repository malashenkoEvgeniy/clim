<?php

namespace App\Modules\Products\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Products\Models\ProductGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class FeatureDestroyRequest
 *
 * @package App\Modules\Features\Requests
 */
class FeatureUpdateRequest extends FormRequest implements RequestInterface
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
        /** @var ProductGroup $group */
        $group = $this->route('group');
        return [
            'feature_id' => ['required', 'integer', Rule::notIn([$group->feature_id]), Rule::exists('features', 'id')],
            'value.*' => ['required', 'integer'],
        ];
    }

}
