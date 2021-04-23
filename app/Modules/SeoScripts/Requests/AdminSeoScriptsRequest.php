<?php

namespace App\Modules\SeoScripts\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class CreateAdmin
 *
 * @package App\Core\Modules\Administrators\Requests
 */
class AdminSeoScriptsRequest extends FormRequest implements RequestInterface
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
        return [
            'place' => ['required', Rule::in(array_keys(config('seo_scripts.places', [])))],
            'name' => ['required', 'string', 'max:191'],
            'active' => ['required', 'boolean'],
            'script' => ['required', 'string'],
        ];
    }

}
