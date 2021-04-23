<?php

namespace App\Modules\FastOrders\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\FastOrders\Models\FastOrder;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Text;
use Illuminate\Database\Eloquent\Model;
use Html;

/**
 * Class ArticleForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class AdminFastOrdersForm implements FormInterface
{

    /**
     * @param  Model|FastOrder|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $model = $model ?? new FastOrder();
        $form = Form::create();
        $form->buttons->doNotShowSaveAndAddButton();
        $user = Text::create('user_id')->setDefaultValue('-----');
        if ($model->user_id) {
            $user = Text::create('user_id')->setDefaultValue(Html::link(route('admin.users.edit',
                $model->user_id), $model->user->name, ['target' => '_blank']));
        }
        // Field set without languages tabs
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('active', $model)->setLabel(__('fast_orders::general.status'))->required(),
            Input::create('created_at', $model)->setOptions(['readonly']),
            Input::create('ip', $model)->setOptions(['readonly']),
            Text::create('phone')->setDefaultValue(Html::tag(
                'div',
                __('validation.attributes.phone').': '. '<a href="tel:'.$model->phone.'">'.$model->phone.'</a>',
                ['class' => ['form-group', 'text-bold']]
            )),
            Text::create('phone')->setDefaultValue(Html::tag(
                'div',
                __('fast_orders::general.product').': '. '<a href="'.route('admin.products.edit', $model->product_id).'" target="_blank">'.$model->product->current->name.'</a>',
                ['class' => ['form-group', 'text-bold']]
            )),
            $user
        );
        return $form;
    }

}
