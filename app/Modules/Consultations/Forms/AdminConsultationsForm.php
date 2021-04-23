<?php

namespace App\Modules\Consultations\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Consultations\Models\Consultation;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminConsultationsForm
 *
 * @package App\Modules\Consultations\Forms
 */
class AdminConsultationsForm implements FormInterface
{
    
    /**
     * @param  Model|Consultation|null $consultation
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $consultation = null): Form
    {
        $consultation = $consultation ?? new Consultation;
        $form = Form::create();
        $form->buttons->doNotShowSaveAndAddButton();
        // Field set without languages tabs
        $form->fieldSet()->add(
            Toggle::create('active', $consultation)->setLabel(__('consultations::general.status'))->required(),
            Input::create('name', $consultation)->setLabel(__('validation.attributes.first_name')),
            Input::create('phone', $consultation)->required(),
            TextArea::create('question', $consultation)->setLabel(__('consultations::general.question'))
        );
        return $form;
    }
    
}
