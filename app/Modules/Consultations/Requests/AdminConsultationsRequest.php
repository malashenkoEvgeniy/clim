<?php

namespace App\Modules\Consultations\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class AdminConsultationsRequest extends FormRequest implements RequestInterface
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
            'name' => ['nullable', 'string', 'min:3', 'max:191'],
            'phone' => ['required', 'string', 'min:10', 'max:191'],
            'question' => ['nullable', 'string', 'min:5', 'max:191'],
        ];
    }
    
}
