<?php

namespace App\Modules\Users\Requests;

use App\Core\Interfaces\RequestInterface;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class UpdateProfileRequest extends FormRequest implements RequestInterface
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
        $user = Auth::user();
        $rules = ['email' => ['required', 'string', 'max:191', 'email', Rule::unique('users')->ignore($user->id)]];
        return $rules;
    }
    
}
