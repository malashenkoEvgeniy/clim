<?php

namespace App\Modules\Articles\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Articles\Images\ArticlesImage;
use App\Modules\Articles\Models\Article;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class ArticleForm implements FormInterface
{
    
    /**
     * @param  Model|Article|null $article
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $article = null): Form
    {
        $article = $article ?? new Article;
        $form = Form::create();
        // Field set with languages tabs
        $form->fieldSetForLang(7)->add(
            InputForSlug::create('name', $article)->required(),
            Slug::create('slug', $article)->required(),
            TextArea::create('short_content', $article),
            TinyMce::create('content', $article),
            Input::create('h1', $article),
            Input::create('title', $article),
            TextArea::create('keywords', $article),
            TextArea::create('description', $article)
        );
        // Simple field set
        $form->fieldSet(5, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $article)->required(),
            Toggle::create('show_short_content', $article)
                ->setLabel('articles::general.labels.show-short-content'),
            Image::create(ArticlesImage::getField(), $article->image),
            Toggle::create('show_image', $article)
                ->setLabel('articles::general.labels.show-image')
        );
        return $form;
    }
    
}
