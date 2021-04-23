<?php

namespace App\Modules\Users\Requests\Site;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Users\Rules\IsUsersEmailUnique;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

/**
 * Class Registration
 *
 * @package App\Modules\Users\Requests\Site
 */
class Registration extends FormRequest implements RequestInterface
{
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::guest();
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:191',
            'phone' => 'nullable|string|regex:/\+380[0-9]{9}/|max:191',
            'email' => ['required', 'string', 'email', 'max:191', new IsUsersEmailUnique()],
            'password' => 'required|string|min:5|confirmed',
            'personal-data-processing' => 'required|in:on',
        ];
    }
    
}
