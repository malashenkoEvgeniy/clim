<?php

namespace App\Core\Modules\Mail\Forms;

use App\Core\Interfaces\FormInterface;
use App\Core\Modules\Mail\Models\MailTemplate;
use CustomForm\Builder\Form;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Text;
use CustomForm\TinyMce;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MailTemplateForm
 *
 * @package App\Core\Modules\MailTemplates\Forms
 */
class MailTemplateForm implements FormInterface
{

    /**
     * @param  Model|MailTemplate|null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $model = null): Form
    {
        $model = $model ?? new MailTemplate;
        $hasVariables = count($model->variables) > 0;
        $form = Form::create();
        $form->fieldSet()->add(
            Toggle::create('active', $model)->required()
        );
        $form->fieldSetForLang($hasVariables ? 7 : 12)->add(
            Input::create('subject', $model)->required(),
            TinyMce::create('text', $model)->required()
        );
        if ($hasVariables) {
            $variables = $form->fieldSet(5);
            foreach ($model->variables as $variableName => $variableLabel) {
                $variables->add(
                    Input::create("var-$variableName")
                        ->setLabel($variableLabel)
                        ->setOptions(['disabled' => true])
                        ->setValue("{{$variableName}}")
                );
            }
        }
        return $form;
    }
    
}
