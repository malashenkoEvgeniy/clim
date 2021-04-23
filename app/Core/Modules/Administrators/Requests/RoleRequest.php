<?php

namespace App\Core\Modules\Administrators\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class RoleRequest extends FormRequest implements RequestInterface
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
            'active' => ['required', 'boolean'],
        ];
    }
    
}
