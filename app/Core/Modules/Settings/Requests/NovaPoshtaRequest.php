<?php

namespace App\Core\Modules\Settings\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NovaPoshtaRequest
 *
 * @package App\Core\Modules\Settings\Requests
 */
class NovaPoshtaRequest extends FormRequest implements RequestInterface
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
            'key' => ['nullable', 'string', 'max:191'],
            'sender-last-name' => ['nullable', 'string', 'max:191'],
            'sender-first-name' => ['nullable', 'string', 'max:191'],
            'sender-middle-name' => ['nullable', 'string', 'max:191'],
            'sender-phone' => ['nullable', 'regex:/^\+?[0-9]{12,15}$/'],
            'sender-city' => ['nullable', 'string', 'max:191'],
            'sender-warehouse' => ['nullable', 'string', 'max:191'],
        ];
    }
    
}
