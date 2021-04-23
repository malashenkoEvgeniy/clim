<?php

namespace App\Modules\Subscribe\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Subscribe\Models\Subscriber;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class AdminMailingForm implements FormInterface
{
    
    /**
     * @param Model|Subscriber|null $subscriber
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $subscriber = null): Form
    {
        $form = Form::create();
        // Field set without languages tabs
        $form->fieldSet()->add(
            Input::create('subject')->required(),
            TinyMce::create('text')->required()
        );
        $form->buttons->doNotShowCloseButton();
        $form->buttons->doNotShowSaveAndAddButton();
        $form->buttons->doNotShowSaveAndCloseButton();
        $form->doNotShowBottomButtons();
        return $form;
    }
    
}
