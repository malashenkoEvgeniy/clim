<?php

namespace App\Modules\Reviews\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Reviews\Images\ReviewsImage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class AdminReviewRequest extends FormRequest implements RequestInterface
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
            'user_id' => ['nullable', 'integer', 'min:1'],
            'name' => ['required', 'string', 'min:2'],
            'email' => ['nullable', 'email'],
            'comment' => ['required', 'string', 'min:2'],
            'published_at' => ['required', 'date'],
        ];
    }
    
}
