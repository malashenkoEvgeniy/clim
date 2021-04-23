<?php

namespace App\Modules\SlideshowSimple\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\SlideshowSimple\Images\SliderBgImage;
use App\Modules\SlideshowSimple\Images\SliderImage;
use App\Modules\SlideshowSimple\Models\SlideshowSimple;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class SlideshowSimpleForm implements FormInterface
{
    
    /**
     * @param Model|SlideshowSimple|null $slideshowSimple
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $slideshowSimple = null): Form
    {
        $slideshowSimple = $slideshowSimple ?? new SlideshowSimple;
        $form = Form::create();
        $image = Image::create(SliderImage::getField(), $slideshowSimple->image);
        if (!$slideshowSimple->image || !$slideshowSimple->image->exists) {
            $image->required();
        }
        // Field set with languages tabs
        $form->fieldSetForLang(12)->add(
            Input::create('name', $slideshowSimple)->required()
        );
        // Simple field set
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $slideshowSimple)->required(),
            Input::create('url', $slideshowSimple),
            $image
        );
        return $form;
    }
    
}
