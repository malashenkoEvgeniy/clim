<?php

namespace App\Core\Modules\Settings\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class WatermarkRequest
 *
 * @package App\Core\Modules\Settings\Requests
 */
class WatermarkRequest extends FormRequest implements RequestInterface
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
            'overlay' => ['required', 'boolean'],
            'position' => ['required', Rule::in(array_keys((array)config('settings.watermark-positions')))],
            'width-percent' => ['required', 'integer', 'min:1', 'max:100'],
            'opacity' => ['required', 'integer', 'min:1', 'max:100'],
            'watermark' => ['nullable', 'image', 'mimes:png'],
        ];
    }

}
