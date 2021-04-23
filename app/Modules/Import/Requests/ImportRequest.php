<?php

namespace App\Modules\Import\Requests;

use App\Components\Parsers\Entry;
use App\Core\Interfaces\RequestInterface;
use App\Modules\Import\Components\ImportSettings;
use App\Modules\Import\Rules\Extension;
use App\Modules\Import\Rules\Import;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ImportRequest
 *
 * @package App\Modules\Import\Requests
 */
class ImportRequest extends FormRequest implements RequestInterface
{
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
            'type' => ['required', Rule::in([Entry::TYPE_YANDEX_MARKET, Entry::TYPE_PROM_UA])],
            'url' => ['bail', 'required_if:type,' . Entry::TYPE_YANDEX_MARKET, 'nullable', 'url'],
            'import' => ['bail', 'required_if:type,' . Entry::TYPE_PROM_UA, 'nullable', 'file', new Extension, new Import],
            'categories' => ['required', Rule::in([
                ImportSettings::CATEGORIES_DO_NOTHING,
                ImportSettings::CATEGORIES_JUST_UPDATE,
                ImportSettings::CATEGORIES_UPDATE_AND_DISABLE_OLD,
            ])],
            'products' => ['required', Rule::in([
                ImportSettings::PRODUCTS_DO_NOTHING,
                ImportSettings::PRODUCTS_JUST_UPDATE,
                ImportSettings::PRODUCTS_UPDATE_AND_DISABLE_OLD,
            ])],
            'images' => ['required', Rule::in([
                ImportSettings::IMAGES_REWRITE,
                ImportSettings::IMAGES_DO_NOT_UPLOAD,
                ImportSettings::IMAGES_ADD,
            ])],
            'course.*' => ['required', 'numeric'],
        ];
    }
    
}
