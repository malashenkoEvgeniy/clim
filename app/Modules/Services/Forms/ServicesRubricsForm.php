<?php

namespace App\Modules\Services\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Services\Images\ServicesRubricImage;
use App\Modules\Services\Models\ServicesRubric;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use CustomForm\Image;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PagesForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class ServicesRubricsForm implements FormInterface
{

    /**
     * @param  Model|ServicesRubric|null $servicesRubric
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $servicesRubric = null): Form
    {
        $servicesRubric = $servicesRubric ?? new ServicesRubric;


        $form = Form::create();

        $image = Image::create(ServicesRubricImage::getField(), $servicesRubric->image);

        // Simple field set
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $servicesRubric)->required()
        );

        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            $image
        );
//        {{dd($servicesRubric);}}
        // Field set with languages tabs
        $form->fieldSetForLang(12)->add(
            InputForSlug::create('name', $servicesRubric)->required(),
            Slug::create('slug', $servicesRubric)->required(),
            TinyMce::create('content', $servicesRubric),
            Input::create('h1', $servicesRubric),
            Input::create('title', $servicesRubric),
            TextArea::create('keywords', $servicesRubric),
            TextArea::create('description', $servicesRubric)
        );
        return $form;
    }

}
