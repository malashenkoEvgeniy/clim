<?php

namespace App\Modules\Orders\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Orders\Models\OrderStatus;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\ColorPicker;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PagesForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class OrderStatusForm implements FormInterface
{
    
    /**
     * @param  Model|OrderStatus|null $status
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $status = null): Form
    {
        $status = $status ?? new OrderStatus;
        $form = Form::create();
        // Simple field set
        $fieldSet = $form->fieldSet(12, FieldSet::COLOR_SUCCESS);
        /*if (!($status && $status->exists) || $status->editable) {
            $fieldSet->add(
                Toggle::create('user_can_cancel', $status)
                    ->setLabel('orders::general.attributes.user_can_cancel')
                    ->required()
            );
        }*/
        $fieldSet->add(
            ColorPicker::create('color', $status)
                ->addClassesToDiv('col-md-3', 'no-padding')
                ->setDefaultValue('#000000')
                ->required()
        );
        // Field set with languages tabs
        $form->fieldSetForLang(12)->add(
            Input::create('name', $status)->required()
        );
        return $form;
    }
    
}
