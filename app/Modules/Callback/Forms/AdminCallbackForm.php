<?php

namespace App\Modules\Callback\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Callback\Models\Callback;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class AdminCallbackForm implements FormInterface
{
    
    /**
     * @param  Model|Callback|null $callback
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $callback = null): Form
    {
        $callback = $callback ?? new Callback;
        $form = Form::create();
        $form->buttons->doNotShowSaveAndAddButton();
        // Field set without languages tabs
        $form->fieldSet()->add(
            Toggle::create('active', $callback)->setLabel(__('callback::general.status'))->required(),
            Input::create('name', $callback)->setLabel(__('validation.attributes.first_name')),
            Input::create('phone', $callback)->required()
        );
        return $form;
    }
    
}
