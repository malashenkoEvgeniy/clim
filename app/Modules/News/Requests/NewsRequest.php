<?php

namespace App\Modules\News\Requests;

use App\Core\Interfaces\RequestInterface;
use App\Modules\News\Images\NewsImage;
use App\Modules\News\Models\News;
use App\Modules\News\Models\NewsTranslates;
use App\Rules\MultilangSlug;
use App\Traits\ValidationRulesTrait;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ArticleRequest
 *
 * @package App\Modules\Articles\Requests
 */
class NewsRequest extends FormRequest implements RequestInterface
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
         *
         *
         * @var News $news
         */
        $news = $this->route('news');
        
        return $this->generateRules(
            [
                'active' => ['required', 'boolean'],
                'published_at' => ['required', 'date'],
                NewsImage::getField() => ['sometimes', 'image', 'max:' . config('image.max-size')],
            ], [
                'name' => ['required', 'max:191'],
                'slug' => [
                    'required',
                    new MultilangSlug(
                        (new NewsTranslates())->getTable(),
                        null,
                        $news ? $news->id : null
                    ),
                ],
            ]
        );
    }
    
}
