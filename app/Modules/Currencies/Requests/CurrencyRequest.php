<?php

namespace App\Modules\Currencies\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CurrencyRequest
 *
 * @package App\Modules\Currencies\Requests
 */
class CurrencyRequest extends FormRequest implements RequestInterface
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
            'name' => ['required', 'string', 'max:191'],
            'sign' => ['required', 'string', 'max:10'],
            'multiplier' => ['required', 'numeric', 'min:0'],
        ];
    }
    
}
