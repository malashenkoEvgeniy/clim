<?php

namespace App\Modules\SiteMenu\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Config;

/**
 * Class SiteMenuRequest
 *
 * @package App\Modules\SiteMenu\Requests
 */
class SiteMenuRequest extends FormRequest implements RequestInterface
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
        return $this->generateRules(
            [
                'active' => ['required', 'boolean'],
                'noindex' => ['required', 'boolean'],
                'nofollow' => ['required', 'boolean'],
                'place' => ['required', 'string', 'min:3'],
            ], [
                'name' => ['required', 'string', 'min:3'],
                'slug' => ['required', 'string', 'min:3'],
            ]
        );
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        foreach (Config::get('languages') as $key => $lang) {
            $attributes = [
                $key.'.name' => trans('validation.attributes.name'),
                $key.'.slug' => trans('validation.attributes.slug')
            ];
        }
        return $attributes;
    }
    
}
