<?php

namespace App\Modules\SeoRedirects\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class AdminSeoRedirectsRequest
 *
 * @package App\Modules\SeoRedirects\Requests
 */
class AdminSeoRedirectsRequest extends FormRequest implements RequestInterface
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
            'type' => ['required', Rule::in(array_keys(config('seo_redirects.types', [])))],
            'active' => ['required', 'boolean'],
            'link_from' => ['required', 'string', 'min:1'],
            'link_to' => ['required', 'string', 'min:1'],
        ];
    }
    
}
