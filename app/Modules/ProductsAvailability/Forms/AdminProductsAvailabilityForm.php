<?php

namespace App\Modules\ProductsAvailability\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\ProductsAvailability\Models\ProductsAvailability;
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
class AdminProductsAvailabilityForm implements FormInterface
{

    /**
     * @param  Model|ProductsAvailability|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $model = $model ?? new ProductsAvailability();
        $form = Form::create();
        $form->buttons->doNotShowSaveAndAddButton();
        $user = Text::create('user_id')->setDefaultValue('-----');
        if ($model->user_id) {
            $user = Text::create('user_id')->setDefaultValue(Html::link(route('admin.users.edit',
                $model->user_id), $model->user->name, ['target' => '_blank']));
        }
        // Field set without languages tabs
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Input::create('created_at', $model)->setOptions(['readonly']),
            Text::create('email')->setDefaultValue(Html::tag(
                'div',
                __('validation.attributes.email').': '. '<a href="mailto:'.$model->email.'">'.$model->email.'</a>',
                ['class' => ['form-group', 'text-bold']]
            )),
            Text::create('product')->setDefaultValue(Html::tag(
                'div',
                __('products-availability::general.product').': '. '<a href="'.route('admin.products.edit', $model->product_id).'" target="_blank">'.$model->product->name.'</a>',
                ['class' => ['form-group', 'text-bold']]
            )),
            $user
        );
        return $form;
    }

}
