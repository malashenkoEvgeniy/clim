<?php

namespace App\Modules\Orders\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ArticleRequest
 *
 * @package App\Modules\Articles\Requests
 */
class OrderAdminRequest extends FormRequest implements RequestInterface
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
        $className = config('auth.providers.users.model');
        $table = $className ? (new $className)->getTable() : null;
        return [
            'user_id' => ['nullable', 'integer', $table ? Rule::exists($table, 'id') : 'min:1'],
            
            'name' => ['required', 'string', 'max:191'],
            'email' => [(bool)config('db.orders.email-is-required', true) ? 'required' : 'nullable', 'string', 'email', 'max:191'],
            'phone' => ['required', 'regex:/\+380[0-9]{9}/', 'string', 'max:191'],
            'locationId' => ['required', 'string', 'max:191'],
    
            'delivery' => ['required', Rule::in(array_keys(config('orders.deliveries', [])))],
            'nova-poshta-self' => ['nullable', 'required_if:delivery,nova-poshta-self', 'nullable', 'string', 'max:191'],
            'nova-poshta' => ['nullable', 'required_if:delivery,nova-poshta', 'nullable', 'string', 'max:191'],
            'address' => ['nullable', 'required_if:delivery,address', 'nullable', 'string', 'max:191'],
            'other' => ['nullable', 'required_if:delivery,other', 'nullable', Rule::in(array_values(config('orders.rest-deliveries', [])))],
            'payment_method' => ['required', Rule::in(array_keys(config('orders.payment-methods', [])))],
            'comment' => ['nullable', 'string', 'max:191'],
            'do_not_call_me' => ['nullable', 'boolean'],
            'paid' => ['nullable', 'boolean'],
            'ttn' => ['nullable', 'string'],
        ];
    }
    
    public function attributes(): array
    {
        return [
            'locationId' => trans('validation.attributes.city'),
        ];
    }
    
}
