<?php

namespace App\Modules\Orders\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Orders\Models\OrderItem;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Hidden;
use CustomForm\Input;
use CustomForm\Text;
use Illuminate\Database\Eloquent\Model;
use Widget;

/**
 * Class OrderItemForm
 *
 * @package App\Modules\Orders\Forms
 */
class OrderItemForm implements FormInterface
{
    
    /**
     * @param  Model|OrderItem|null $item
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $item = null): Form
    {
        $item = $item ?? new OrderItem;
        $form = Form::create();
        // Simple field set
        $fieldSet = $form->fieldSet(12, FieldSet::COLOR_SUCCESS);
        $fieldSet->add(
            Hidden::create('price', $item)->setDefaultValue(0),
            Text::create('product')
                ->setLabel('orders::general.choose-product')
                ->setDefaultValue(Widget::show('products::groups::live-search', [], 'product_id', null, ['data-type' => 'product']))
                ->required(),
            Input::create('quantity', $item)
                ->setType('number')
                ->setLabel('orders::general.quantity')
                ->setDefaultValue(1)
                ->setOptions(['min' => 1])
                ->required()
        );
        $form->buttons->doNotShowSaveAndCloseButton();
        $form->buttons->doNotShowSaveAndAddButton();
        return $form;
    }
    
}
