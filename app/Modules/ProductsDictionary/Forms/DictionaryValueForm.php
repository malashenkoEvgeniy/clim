<?php

namespace App\Modules\ProductsDictionary\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\ProductsDictionary\Models\Dictionary;
use CustomForm\Builder\Form;
use CustomForm\Input;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DictionaryValueForm
 *
 * @package App\Modules\ProductsDictionary\Forms
 */
class DictionaryValueForm implements FormInterface
{

    /**
     * @param  Model|Dictionary|null $value
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $value = null): Form
    {
        $value = $value ?? new Dictionary;
        $form = Form::create()->ajax();
        $form->fieldSetForLang(12)->add(
            Input::create('name', $value)->required()
        );
        /*$form->fieldSet(12, FieldSet::COLOR_PRIMARY)->add(
            Toggle::create('active')
                ->setLabel('products_dictionary::admin.value-active')
                ->setDefaultValue($value->active ?? true)
        );*/
        $form->buttons->forceShowSaveButton();
        return $form;
    }

}
