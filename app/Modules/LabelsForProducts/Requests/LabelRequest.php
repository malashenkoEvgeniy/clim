<?php

namespace App\Modules\LabelsForProducts\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\LabelsForProducts\Models\Label;
use App\Modules\LabelsForProducts\Models\LabelTranslates;
use App\Rules\MultilangSlug;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class LabelRequest
 *
 * @package App\Modules\LabelsForProducts\Requests
 */
class LabelRequest extends FormRequest implements RequestInterface
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
     * @throws \App\Exceptions\WrongParametersException
     */
    public function rules(): array
    {
        /** @var Label $label */
        $label = $this->route('label');
        
        return $this->generateRules([
            'active' => ['required', 'bool'],
            'color' => ['required', 'regex:/^(\#[\da-f]{3}|\#[\da-f]{6}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/'],
        ], [
            'name' => ['required', 'max:191'],
            'text' => ['required', 'max:10'],
            'slug' => ['required', 'max:191', new MultilangSlug(
                (new LabelTranslates())->getTable(),
                null,
                $label->id ?? null
            )],
        ]);
    }
    
}
