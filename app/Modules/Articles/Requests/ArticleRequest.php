<?php

namespace App\Modules\Articles\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\Articles\Images\ArticlesImage;
use App\Modules\Articles\Models\Article;
use App\Modules\Articles\Models\ArticleTranslates;
use App\Rules\MultilangSlug;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ArticleRequest
 *
 * @package App\Modules\Articles\Requests
 */
class ArticleRequest extends FormRequest implements RequestInterface
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
         * @var Article $article
         */
        $article = $this->route('article');
        
        return $this->generateRules(
            [
                'active' => ['required', 'boolean'],
                ArticlesImage::getField() => ['sometimes', 'image', 'max:' . config('image.max-size')],
            ], [
                'name' => ['required', 'max:191'],
                'slug' => [
                    'required',
                    new MultilangSlug(
                        (new ArticleTranslates)->getTable(),
                        null,
                        $article ? $article->id : null
                    ),
                ],
            ]
        );
    }
    
}
