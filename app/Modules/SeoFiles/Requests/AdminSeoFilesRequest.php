<?php

namespace App\Modules\SeoFiles\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class AdminSeoFilesRequest
 *
 * @package App\Modules\SeoFiles\Requests
 */
class AdminSeoFilesRequest extends FormRequest implements RequestInterface
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
            'name' => ['sometimes', 'string', 'min:1', 'max:32'],
            'type' => ['sometimes', Rule::in(array_keys(config('seo_files.types', [])))],
            'content' => ['nullable', 'string'],
        ];
    }
    
}
