<?php

namespace App\Modules\Orders\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Orders\Models\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ChangeOrderStatusRequest
 *
 * @package App\Modules\Orders\Requests
 */
class ChangeOrderStatusRequest extends FormRequest implements RequestInterface
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
            'status_id' => ['required', 'integer', Rule::exists((new OrderStatus)->getTable(), 'id')],
            'comment' => ['required', 'string', 'max:191'],
        ];
    }
    
}
