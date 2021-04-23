<?php

namespace App\Modules\Categories\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Categories\Images\CategoryImage;
use App\Modules\Categories\Models\Category;
use App\Modules\Categories\Models\CategoryTranslates;
use App\Modules\Categories\Rules\AvailableToChooseCategory;
use App\Rules\MultilangSlug;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Config;

/**
 * Class GalleryRequest
 * @package App\Modules\Gallery\Requests
 */
class CategoryRequest extends FormRequest implements RequestInterface
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
     * @throws \App\Exceptions\WrongParametersException
     */
    public function rules(): array
    {
        /** @var Category $category */
        $category = $this->route('category');
        
        $parentIdRules = ['nullable'];
        if ($category) {
            $parentIdRules[] = new AvailableToChooseCategory($category);
        }

        return $this->generateRules([
            'active' => ['required', 'boolean'],
            CategoryImage::getField() => ['sometimes', 'image', 'max:' . config('image.max-size')],
            'parent_id' => ['nullable', $parentIdRules],
        ], [
            'name' => ['required', 'max:191'],
            'slug' => [
                'required',
                new MultilangSlug(
                    (new CategoryTranslates())->getTable(),
                    null,
                    $category->id ?? null
                ),
            ],
        ]);
    }

    /**
     * @return array
     */
    public function attributes()
    {
        $attributes = [];
        foreach (Config::get('languages') as $key => $lang) {
            $attributes = [
                $key.'.slug' => trans('validation.attributes.slug')
            ];
        }
        return $attributes;
    }
    
}
