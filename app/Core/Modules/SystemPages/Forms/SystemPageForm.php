<?php

namespace App\Core\Modules\SystemPages\Forms;

use App\Core\Interfaces\FormInterface;
use App\Core\Modules\SystemPages\Models\SystemPage;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\TextArea;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SystemPageForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class SystemPageForm implements FormInterface
{
    
    /**
     * @param  Model|SystemPage|null $systemPage
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $systemPage = null): Form
    {
        $systemPage = $systemPage ?? new SystemPage();
        $form = Form::create();
        $form->buttons->doNotShowSaveAndAddButton();
        // Field set with languages tabs
        $form->fieldSetForLang()->add(
            Input::create('name', $systemPage)->required(),
            TinyMce::create('content', $systemPage),
            Input::create('h1', $systemPage),
            Input::create('title', $systemPage),
            TextArea::create('keywords', $systemPage),
            TextArea::create('description', $systemPage)
        );
        return $form;
    }
    
}
