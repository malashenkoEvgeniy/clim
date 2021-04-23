<?php

namespace App\Modules\SeoTemplates\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class AdminSeoTemplatesRequest extends FormRequest implements RequestInterface
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
        return $this->generateRules([], [
            'name' => ['required', 'string', 'max:191'],
            'h1' => ['required', 'string', 'max:191'],
            'title' => ['required', 'string', 'max:191'],
            'keywords' => ['string'],
            'description' => ['string'],
        ]);
    }

}
