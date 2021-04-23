<?php

namespace App\Modules\Orders\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CheckoutContactInformationRequest
 *
 * @package App\Modules\Orders\Requests
 */
class CheckoutContactInformationRequest extends FormRequest implements RequestInterface
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
        if (request()->expectsJson()) {
            $regex = 'regex:/^[a-zA-Zа-яА-ЯіІїЇєёЁЄґҐĄąĆćĘęŁłŃńÓóŚśŹźŻż\.\'\`\- ]*$/u';
        } else {
            $regex = 'regex:/^[a-zA-Zа-яА-ЯіІїЇєёЁЄґҐĄąĆćĘęŁłŃńÓóŚśŹźŻż\.\'\`\- ]*$/';
        }

        return [
            'email' => [(bool)config('db.orders.email-is-required', true) ? 'required' : 'nullable', 'email', 'string', 'max:191'],
            'phone' => ['required', 'regex:/\+380[0-9]{9}/', 'string', 'max:191'],
            'name' => ['nullable', 'string', 'max:191', $regex],
            'locationId' => ['required', 'string', 'max:191'],
        ];
    }

    public function attributes(): array
    {
        return [
            'email' => trans('orders::site.validation.attributes.email'),
            'phone' => trans('orders::site.validation.attributes.phone'),
            'name' => trans('orders::site.validation.attributes.name'),
            'location' => trans('validation.attributes.city'),
            'locationId' => trans('validation.attributes.city'),
        ];
    }

}
