<?php

namespace App\Modules\ProductsServices\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductServiceRequest
 *
 * @package App\Modules\ProductsServices\Requests
 */
class ProductServiceRequest extends FormRequest implements RequestInterface
{
    use ValidationRulesTrait;
    
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return $this->generateRules([
            'active' => ['required', 'boolean'],
        ], [
            'name' => ['required', 'max:191'],
            'description' => ['required'],
            'text' => ['required'],
        ]);
    }
    
}
