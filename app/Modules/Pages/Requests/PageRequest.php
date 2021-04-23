<?php

namespace App\Modules\Pages\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Pages\Models\Page;
use App\Modules\Pages\Models\PageTranslates;
use App\Rules\MultilangSlug;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class ArticleRequest
 *
 * @package App\Modules\Articles\Requests
 */
class PageRequest extends FormRequest implements RequestInterface
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
         * @var Page $page
         */
        $page = $this->route('page');
        
        return $this->generateRules(
            [
                'active' => ['required', 'boolean'],
                'parent_id' => ['nullable', 'numeric', Rule::notIn([$page ? $page->id : null])],
            ], [
                'name' => ['required', 'max:191'],
                'slug' => [
                    'required',
                    new MultilangSlug(
                        (new PageTranslates())->getTable(),
                        null,
                        $page ? $page->id : null
                    ),
                ],
                'menu' => ['nullable','numeric']
            ]
        );
    }
    
}
