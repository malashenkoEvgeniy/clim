<?php

namespace App\Modules\Orders\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateCartRequest
 *
 * @package App\Modules\Orders\Requests
 */
class UpdateCartRequest extends FormRequest implements RequestInterface
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
            'product_id' => ['integer'],
            'product_data.quantity' => ['required', 'integer', 'min:1', 'max:9999'],
        ];
        return $rules;
    }
    
    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'product_data.quantity' => trans('orders::site.validation.attributes.product_data_quantity'),
        ];
    }
    
}
