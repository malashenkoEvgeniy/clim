<?php

namespace App\Modules\Comments\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class SiteCommentRequest
 *
 * @package App\Core\Modules\Comments\Requests
 */
class SiteCommentRequest extends FormRequest implements RequestInterface
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
            'email' => ['required', 'email'],
            'comment' => ['required', 'string', 'min:2'],
            'commentable_id' => ['required', 'integer', 'min:1'],
            'commentable_type' => ['required', 'string'],
            'mark' => ['nullable', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'personal-data-processing' => 'required|in:on',
        ];
    }
    
}
