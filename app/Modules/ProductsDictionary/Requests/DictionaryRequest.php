<?php

namespace App\Modules\ProductsDictionary\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

/**
 * Class DictionaryRequest
 *
 * @package App\Modules\ProductsDictionary\Requests
 */
class DictionaryRequest extends FormRequest implements RequestInterface
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
            [],
            [
                'products_dictionary_title' => ['required', 'string', 'max:191']
            ]
        );
    }

}
