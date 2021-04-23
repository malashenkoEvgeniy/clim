<?php

namespace App\Core\Modules\Administrators\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Core\Modules\Administrators\Images\AdminAvatar;
use App\Core\Modules\Administrators\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class AdminUpdateRequest extends FormRequest implements RequestInterface
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        /**
         *
         *
         * @var Admin $admin
         */
        $admin = $this->route('admin');
        
        if (!$admin->couldBeEdited()) {
            return false;
        }
        
        return $admin ? $admin->exists() : false;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        /**
         * @var Admin $admin
         */
        $admin = $this->route('admin');
        
        return [
            'first_name' => ['required', 'string', 'min:2'],
            'email' => ['required', 'email', Rule::unique('admins')->ignore($admin ? $admin->id : null)],
            'password' => ['nullable', 'min:5', 'max:32'],
            AdminAvatar::getField() => ['sometimes', 'image', 'max:' . config('image.max-size')],
        ];
    }
    
}
