<?php

namespace App\Modules\Subscribe\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Subscribe\Models\Subscriber;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class AdminSubscriberForm implements FormInterface
{
    
    /**
     * @param  Model|Subscriber|null $subscriber
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $subscriber = null): Form
    {
        $subscriber = $subscriber ?? new Subscriber;
        $form = Form::create();
        // Field set without languages tabs
        $form->fieldSet()->add(
            Toggle::create('active', $subscriber)->setLabel(__('subscribe::general.status'))->required(),
            Input::create('email', $subscriber)->required(),
            Input::create('name', $subscriber)
                ->setLabel('validation.attributes.first_name')
        );
        return $form;
    }
    
    public function attributes()
    {
        return [
            'name' => __('validation.attributes.first_name'),
        ];
    }
    
}
