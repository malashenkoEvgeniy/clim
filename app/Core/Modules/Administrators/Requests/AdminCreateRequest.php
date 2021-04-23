<?php

namespace App\Core\Modules\Administrators\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Core\Modules\Administrators\Images\AdminAvatar;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class AdminCreateRequest extends FormRequest implements RequestInterface
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
            'first_name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'email', Rule::unique('admins')],
            'password' => ['required', 'min:5', 'max:32'],
            AdminAvatar::getField() => ['sometimes', 'image', 'max:' . config('image.max-size')],
        ];
    }
    
}
