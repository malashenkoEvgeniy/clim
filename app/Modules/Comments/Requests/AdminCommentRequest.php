<?php

namespace App\Modules\Comments\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class AdminCommentRequest
 *
 * @package App\Core\Modules\Comments\Requests
 */
class AdminCommentRequest extends FormRequest implements RequestInterface
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
            'user_id' => ['nullable', Rule::exists('users', 'id')],
            'name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'email'],
            'comment' => ['required', 'string', 'min:2'],
            'commentable_id' => ['required', 'integer', 'min:1'],
            'published_at' => ['required', 'date'],
            
            'mark' => ['nullable', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'answered_at' => ['required_with:answer', 'nullable', 'date', 'after:published_at'],
            'answer' => ['required_with:answered_at', 'nullable', 'string'],
        ];
    }
    
}
