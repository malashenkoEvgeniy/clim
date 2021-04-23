<?php

namespace App\Modules\Orders\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CheckoutContactInformationRequest
 *
 * @package App\Modules\Orders\Requests
 */
class CheckoutDeliveryAndPaymentRequest extends FormRequest implements RequestInterface
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
            'delivery' => ['required', Rule::in(array_keys(config('orders.deliveries', [])))],
            'nova-poshta-self' => ['nullable', 'required_if:delivery,nova-poshta-self', 'nullable', 'string', 'max:191'],
            'nova-poshta' => ['nullable', 'required_if:delivery,nova-poshta', 'nullable', 'string', 'max:191'],
            'address' => ['nullable', 'required_if:delivery,address', 'nullable', 'string', 'max:191'],
            'other' => ['nullable', 'required_if:delivery,other', 'nullable', Rule::in(array_values(config('orders.rest-deliveries', [])))],
            'payment_method' => ['required', Rule::in(array_keys(config('orders.payment-methods', [])))],
            'comment' => ['nullable', 'string', 'max:191'],
            'do_not_call_me' => ['nullable', 'boolean'],
        ];
    }
    
}
