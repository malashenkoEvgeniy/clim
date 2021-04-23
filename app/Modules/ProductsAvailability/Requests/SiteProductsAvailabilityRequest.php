<?php

namespace App\Modules\ProductsAvailability\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class SiteProductsAvailabilityRequest
 * @package App\Modules\FastOrders\Requests
 */
class SiteProductsAvailabilityRequest extends FormRequest implements RequestInterface
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
            'email' => ['required', 'email'],
            'personal-data-processing' => 'required|in:on',
            'user_id' => ['sometimes', Rule::exists('users', 'id')],
            'product_id' => ['required', Rule::exists('products', 'id')],
        ];
    }

}
