<?php

namespace App\Core\Modules\Administrators\Forms;

use App\Core\Interfaces\FormInterface;
use App\Core\Modules\Administrators\Models\Role;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Group\Checkbox;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use Illuminate\Database\Eloquent\Model;
use CustomRoles;
use CustomForm\Group\Group;

/**
 * Class RolesForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class RolesForm implements FormInterface
{
    
    /**
     * @param  Model|Role|null $role
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $role = null): Form
    {
        $form = Form::create();
        // Simple form
        $form->fieldSet(12, FieldSet::COLOR_WARNING)->add(
            Toggle::create('active', $role)->required(),
            Input::create('name', $role)->required()
        );
        // Rules for current role
        $rules = $form->fieldSet(12, FieldSet::COLOR_DEFAULT);
        foreach (CustomRoles::get() as $moduleName => $scope) {
            // Checkboxes list
            $group = new Group($moduleName);
            $group->setLabel(__($scope->name));
            // Add checkboxes
            foreach ($scope->toArray() as $rule => $turnOn) {
                if ($turnOn === true) {
                    // Add one checkbox
                    $group->add(
                        Checkbox::create($moduleName . '[' . $rule . ']')
                            ->setOptions(
                                [
                                    'checked' => $role ? $role->can("$moduleName.$rule") : false,
                                ]
                            )
                            ->setValue(1)
                            ->setLabel(__("admins::roles.rules.$rule"))
                    );
                }
            }
            // Add block to list
            $rules->add($group);
        }
        return $form;
    }
    
}
