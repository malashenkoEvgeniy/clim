<?php

namespace App\Modules\Reviews\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use App\Modules\Reviews\Images\ReviewsImage;

/**
 * Class SiteCallbackRequest
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class SiteReviewRequest extends FormRequest implements RequestInterface
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
            'name' => ['required', 'string', 'min:2'],
            'comment' => ['required', 'string', 'min:10'],
            'personal-data-processing' => ['required', 'in:on'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'required' => trans('reviews::site.required'),
        ];
    }
    
}
