<?php

namespace App\Core\Modules\Mail\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class MailTemplateRequest
 *
 * @package App\Core\Modules\Mail\Requests
 */
class MailTemplateRequest extends FormRequest implements RequestInterface
{
    use ValidationRulesTrait;
    
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
        return $this->generateRules([
            'active' => ['required', 'boolean'],
        ], [
            'subject' => ['required', 'string', 'max:191'],
            'text' => ['required', 'string'],
        ]);
    }
    
}
