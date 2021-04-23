<?php

namespace App\Modules\Callback\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SiteCallbackRequest
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class SiteCallbackRequest extends FormRequest implements RequestInterface
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
            'name' => ['nullable', 'string', 'min:3', 'max:191'],
            'phone' => ['required', 'string', 'min:10', 'max:191'],
            'personal-data-processing' => ['required', 'in:on'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'required' => trans('callback::site.required'),
        ];
    }
    
}
