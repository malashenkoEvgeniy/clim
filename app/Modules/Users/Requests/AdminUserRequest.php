<?php

namespace App\Modules\Users\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Users\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class AdminUserRequest extends FormRequest implements RequestInterface
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
     * @param  int $userId
     * @return array
     */
    public function rules(int $userId = null): array
    {
        if ($userId === null) {
            /** @var User $user */
            $user = $this->route('user');
            $userId = $user ? $user->id : null;
        }
        
        return [
            'email' => ['required', 'string', 'max:191', 'email', Rule::unique('users')->ignore($userId)],
            'phone' => ['nullable', 'string', 'max:191', 'regex:/\+380[0-9]{9}/'],
            'password' => [$userId ? 'nullable' : 'required', 'min:5', 'max:32'],
        ];
    }
    
}
