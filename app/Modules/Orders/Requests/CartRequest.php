<?php

namespace App\Modules\Orders\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddToCartRequest
 *
 * @package App\Modules\Orders\Requests
 */
class CartRequest extends FormRequest implements RequestInterface
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
        $rules = [
            'product_id' => ['required', 'array'],
            'product_id.*' => ['integer'],
        ];
        return $rules;
    }
    
}
