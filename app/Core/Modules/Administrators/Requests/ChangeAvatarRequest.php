<?php

namespace App\Core\Modules\Administrators\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Core\Modules\Administrators\Images\AdminAvatar;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class ChangeAvatarRequest extends FormRequest implements RequestInterface
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
            AdminAvatar::getField() => ['required', 'image', 'max:' . config('image.max-size')],
        ];
    }
    
}
