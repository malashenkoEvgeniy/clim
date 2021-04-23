<?php

namespace App\Modules\SeoLinks\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\SeoLinks\Models\SeoLink;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminSeoLinksForm
 *
 * @package App\Core\Modules\SeoLinks\Forms
 */
class AdminSeoLinksForm implements FormInterface
{

    /**
     * @param  Model|SeoLink|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $model = $model ?? new SeoLink;
        $form = Form::create();
        // Simple field set
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $model)->required(),
            Input::create('url', $model)->required()
        );
        // Field set without languages tabs
        $form->fieldSetForLang(12)->add(
            Input::create('name', $model)->required(),
            Input::create('h1', $model),
            Input::create('title', $model),
            TextArea::create('keywords', $model),
            TextArea::create('description', $model)
        );
        return $form;
    }

}
