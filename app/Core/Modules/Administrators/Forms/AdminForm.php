<?php

namespace App\Core\Modules\Administrators\Forms;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Core\Interfaces\FormInterface;
use App\Core\Modules\Administrators\Images\AdminAvatar;
use App\Core\Modules\Administrators\Models\Admin;
use App\Core\Modules\Administrators\Models\Role;
use CustomForm\Builder\Form;
use CustomForm\Image;
use CustomForm\Input;
use CustomForm\Macro\MultiSelect;
use CustomForm\Macro\Toggle;
use CustomForm\Password;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class AdminForm implements FormInterface
{
    
    /**
     * @param  Model|Admin|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $model = $model ?? new Admin();
        $form = Form::create();
        $password = Password::create('password');
        $image = Image::create(AdminAvatar::getField(), $model->image);
        if (!$model->exists) {
            $password->required();
        }
        $form->fieldSet()->add(
            Toggle::create('active', $model)->required(),
            Input::create('first_name', $model)->required(),
            Input::create('email', $model)->required(),
            MultiSelect::create('roles[]')
                ->setLabel(__('admins::attributes.roles'))
                ->setValue($model ? $model->roles_ids : [])
                ->model(ModelForSelect::make(Role::available())),
            $image,
            $password
        );
        return $form;
    }
    
}
