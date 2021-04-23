<?php

namespace App\Modules\LabelsForProducts\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\LabelsForProducts\Models\Label;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\Macro\ColorPicker;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LabelForm
 *
 * @package App\Core\Modules\LabelsForProducts\Forms
 */
class LabelForm implements FormInterface
{

    /**
     * @param  Model|Label|null $label
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $label = null): Form
    {
        $label = $label ?? new Label;
        $form = Form::create();
        $form->fieldSet()->add(
            Toggle::create('active', $label)->required()->setDefaultValue(true),
            ColorPicker::create('color', $label)
                ->addClassesToDiv('col-md-3', 'no-padding')
                ->setDefaultValue('#000000')
                ->required()

        );
        $form->fieldSetForLang()->add(
            InputForSlug::create('name', $label)->required(),
            Slug::create('slug', $label)->required(),
            Input::create('text', $label)->setLabel('labels::general.attributes.text')->required(),
            Input::create('h1', $label),
            Input::create('title', $label),
            TextArea::create('keywords', $label),
            TextArea::create('description', $label),
            TinyMce::create('content', $label)
        );
        return $form;
    }

}
