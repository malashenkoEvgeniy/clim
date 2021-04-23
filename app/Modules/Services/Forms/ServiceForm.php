<?php

namespace App\Modules\Services\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Services\Images\ServicesImage;
use App\Modules\Services\Models\ServicesRubric;
use App\Modules\Services\Models\Service;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Hidden;
use CustomForm\Input;
use CustomForm\Image;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PagesForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class ServiceForm implements FormInterface
{

    /**
     * @param  Model|Service|null $service
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $service = null): Form
    {
        $rubrics = [];
        $service = $service ?? new Service;
        $servicesRubrics = ServicesRubric::getList();

        foreach ($servicesRubrics as $servicesRubric) {
            $rubrics[$servicesRubric->id] = $servicesRubric->current->name;
        }


        $image = Image::create(ServicesImage::getField(), $service->image);

        $form = Form::create();
        // Simple field set
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Hidden::create('parent_id', $service)->setValue(0),
            Toggle::create('active', $service)->required()
        );

        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            $image
        );


        // Field set with languages tabs
        $form->fieldSetForLang(12)->add(
            InputForSlug::create('name', $service)->required(),
            Slug::create('slug', $service)->required(),
            TinyMce::create('content', $service),
            Input::create('h1', $service),
            Input::create('title', $service),
            TextArea::create('keywords', $service),
            TextArea::create('description', $service)
        );

        return $form;
    }

}
