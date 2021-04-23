<?php

namespace App\Modules\Users\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Users\Rules\PhoneVerification;
use App\Rules\CurrentPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ChangePhoneRequest
 *
 * @package App\Modules\Users\Requests
 */
class ChangePhoneRequest extends FormRequest implements RequestInterface
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
            'password' => ['required', 'min:4', 'max:32', new CurrentPassword],
            'phone' => ['required', 'string', 'max:191', 'regex:/\+380[0-9]{9}/', Rule::unique('users')],
            'code' => ['required', new PhoneVerification],
        ];
    }
    
}
