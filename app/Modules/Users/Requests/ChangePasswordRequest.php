<?php

namespace App\Modules\Users\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class ChangePasswordRequest extends FormRequest implements RequestInterface
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
            'current_password' => ['required', new CurrentPassword(), 'min:4', 'max:32'],
            'new_password' => ['required', 'different:current_password', 'min:5', 'max:32', 'confirmed'],
        ];
    }
    
}
