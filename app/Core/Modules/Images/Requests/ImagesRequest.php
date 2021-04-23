<?php

namespace App\Core\Modules\Images\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ImagesRequest
 * @package App\Coew\Modules\Images\Requests
 */
class ImagesRequest extends FormRequest implements RequestInterface
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
        return $this->generateRules([], [
            'alt' => ['nullable', 'string', 'max:191'],
            'title' => ['nullable', 'string', 'max:191'],
        ]);
    }
    
}
