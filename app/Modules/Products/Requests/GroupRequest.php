<?php

namespace App\Modules\Products\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Brands\Rules\IsBrand;
use App\Modules\Categories\Rules\CategoryExists;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GroupRequest
 *
 * @package App\Modules\Products\Requests
 */
class GroupRequest extends FormRequest implements RequestInterface
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
            'category_id' => ['required', new CategoryExists],
            'brand_id' => ['nullable', new IsBrand],
            'position' => ['required', 'integer'],
        ], [
            'name' => ['required', 'max:191'],
        ]);
    }
    
}
