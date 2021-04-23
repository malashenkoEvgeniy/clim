<?php

namespace App\Modules\Orders\Forms;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Core\Interfaces\FormInterface;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderStatus;
use CustomForm\Builder\Form;
use CustomForm\Hidden;
use CustomForm\Select;
use CustomForm\Submit;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderForm
 *
 * @package App\Modules\Orders\Forms
 */
class ChangeStatusForm implements FormInterface
{
    
    /**
     * @param Model|Order|null $order
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $order = null): Form
    {
        $order = $order ?? new Order;
        $form = Form::create();
        $fieldSet = $form->simpleFieldSet();
        $fieldSet->add(
            Select::create('status_id')
                ->setLabel(trans('orders::general.choose-order-status'))
                ->model(ModelForSelect::make(OrderStatus::getList())->setValueFieldName('current.name'))
                ->setDefaultValue($order->status_id)->required(),
            TextArea::create('comment')->setOptions(['rows' => 3])->required(),
            Submit::create('submit')
                ->setValue(trans('orders::general.change-order-status'))
                ->addClasses('btn', 'btn-primary')
                ->setLabel(false)
        );
        $form->doNotShowTopButtons();
        $form->doNotShowBottomButtons();
        return $form;
    }
    
}
