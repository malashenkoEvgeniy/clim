<?php

namespace App\Modules\Users\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Users\Models\User;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\DatePicker;
use CustomForm\Macro\Toggle;
use CustomForm\Password;
use CustomForm\Select;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class AdminUserForm implements FormInterface
{
    
    /**
     * @param  Model|User|null $user
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $user = null): Form
    {
        $form = Form::create();
        $form->fieldSet(7, FieldSet::COLOR_DEFAULT, __('users::general.personal-info'))->add(
            Input::create('last_name', $user),
            Input::create('first_name', $user),
            Input::create('phone', $user)
        );
        $password = Password::create('password');
        if (!$user) {
            $password->required();
        }
        $form->fieldSet(5, FieldSet::COLOR_PRIMARY, __('users::general.settings'))->add(
            Toggle::create('active', $user)->required(),
            Input::create('email', $user)->required(),
            $password
        );
        return $form;
    }
    
}
