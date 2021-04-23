<?php

namespace App\Modules\Features\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Features\Models\Feature;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class FeatureDestroyRequest
 *
 * @package App\Modules\Features\Requests
 */
class FeatureDestroyRequest extends FormRequest implements RequestInterface
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
        /** @var Feature $feature */
        $feature = $this->route('feature');

        return [
            'feature_id' => ['required', 'integer', Rule::notIn([$feature->id]), Rule::exists('features','id')],
            'value.*' => ['required', 'integer'],
        ];
    }

}
