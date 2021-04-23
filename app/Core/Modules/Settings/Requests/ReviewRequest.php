<?php

namespace App\Core\Modules\Settings\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ReviewRequest
 *
 * @package App\Core\Modules\Settings\Requests
 */
class ReviewRequest extends FormRequest implements RequestInterface
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
            'per-page' => ['required', 'integer', 'min:1'],
            'per-page-client-side' => ['required', 'integer', 'min:1'],
            'count-in-widget' => ['required', 'integer', 'min:1', 'max:20'],
            'background' => ['sometimes', 'image', 'max:' . config('image.max-size')],
        ];
    }
    
    public function attributes()
    {
        return [
            'per-page' => trans('reviews::settings.attributes.per-page'),
            'per-page-client-side' => trans('reviews::settings.attributes.per-page-client-side'),
            'count-in-widget' => trans('reviews::settings.attributes.count-in-widget'),
            'background' => trans('reviews::settings.attributes.background'),
        ];
    }
    
}
