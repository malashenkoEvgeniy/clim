<?php
/**
 * Created by PhpStorm.
 * User: smekodyb.s
 * Date: 21.06.2019
 * Time: 10:39
 */

namespace App\Modules\Services\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Services\Images\ServicesImage;
use App\Modules\Services\Models\Service;
use App\Modules\Services\Models\ServiceTranslates;
use App\Rules\MultilangSlug;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest implements RequestInterface
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
        /**
         * @var Service $service
         */
        $service = $this->route('service');

        return $this->generateRules(
            [
                'active' => ['required', 'boolean'],
                'parent_id' => ['required', 'numeric'],
                ServicesImage::getField() => ['sometimes', 'image', 'max:' . config('image.max-size')],
            ],
            [
                'name' => ['required', 'max:191'],
                'slug' => [
                    'required',
                    new MultilangSlug(
                        (new ServiceTranslates())->getTable(),
                        null,
                        $service ? $service->id : null
                    ),
                ],
            ]
        );
    }
}