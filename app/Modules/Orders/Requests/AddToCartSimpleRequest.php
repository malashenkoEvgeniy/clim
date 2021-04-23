<?php

namespace App\Modules\Orders\Requests;

use App\Core\Interfaces\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Catalog;

/**
 * Class AddToCartRequest
 *
 * @package App\Modules\Orders\Requests
 */
class AddToCartSimpleRequest extends FormRequest implements RequestInterface
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
            'product_id' => ['integer'],
        ];
    }
    
}
