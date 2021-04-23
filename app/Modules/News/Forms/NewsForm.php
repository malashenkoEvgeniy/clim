<?php

namespace App\Modules\News\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\News\Images\NewsImage;
use App\Modules\News\Models\News;
use Carbon\Carbon;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\DateTimePicker;
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
class NewsForm implements FormInterface
{
    
    /**
     * @param  Model|News|null $news
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $news = null): Form
    {
        $news = $news ?? new News;
        $form = Form::create();
        // Field set with languages tabs
        $form->fieldSetForLang(7)->add(
            InputForSlug::create('name', $news)->required(),
            Slug::create('slug', $news)->required(),
            TextArea::create('short_content', $news),
            TinyMce::create('content', $news),
            Input::create('h1', $news),
            Input::create('title', $news),
            TextArea::create('keywords', $news),
            TextArea::create('description', $news)
        );
        // Simple field set
        $form->fieldSet(5, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $news)->required(),
            Toggle::create('show_short_content', $news)->setLabel('news::general.labels.show-short-content'),
            //Input::create('published_at')->setValue(Carbon::parse($news->published_at)->toDateTimeString())->addClasses('')->required(),
            DateTimePicker::create('published_at', $news)->required(),
            Image::create(NewsImage::getField(), $news->image),
            Toggle::create('show_image', $news)->setLabel('news::general.labels.show-image')
        );
        return $form;
    }
    
}
