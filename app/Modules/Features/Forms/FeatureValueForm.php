<?php

namespace App\Modules\Features\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Features\Models\FeatureValue;
use CustomForm\Builder\Form;
use Illuminate\Database\Eloquent\Model;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;

/**
 * Class FeatureValueForm
 *
 * @package App\Core\Modules\Features\Forms
 */
class FeatureValueForm implements FormInterface
{

    /**
     * @param  Model|FeatureValue|null $value
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $value = null): Form
    {
        $value = $value ?? new FeatureValue;
        $form = Form::create()->ajax();
        $form->fieldSetForLang(12)->add(
            InputForSlug::create('name', $value)->required(),
            Slug::create('slug', $value)->required()
        );
        $form->buttons->forceShowSaveButton();
        return $form;
    }

}
