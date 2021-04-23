<?php

namespace App\Modules\SeoLinks\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AdminSeoLinksRequest
 *
 * @package App\Modules\SeoLinks\Requests
 */
class AdminSeoLinksRequest extends FormRequest implements RequestInterface
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
     * @return array
     */
    public function rules(): array
    {
        return $this->generateRules([
            'url' => ['required', 'string', 'max:191'],
        ], [
            'name' => ['required', 'string', 'max:191'],
        ]);
    }
}
