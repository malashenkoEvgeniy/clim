<?php

namespace App\Modules\Features\Forms;

use App\Core\Interfaces\FormInterface;
use App\Modules\Features\Models\FeatureValue;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use App\Modules\Features\Models\Feature;
use CustomForm\Hidden;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\Text;
use CustomForm\TextArea;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AjaxFeatureForm
 *
 * @package App\Core\Modules\Features\Forms
 */
class AjaxFeatureForm implements FormInterface {

    /**
     * @param  Model|Feature|null $feature
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $feature = null): Form
    {
        $feature = new Feature;
        $value = new FeatureValue;
        $form = Form::create();
        $form->ajax();
        $form->doNotShowTopButtons();
        $form->fieldSet(12, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('features-in_filter', $feature)->required()->setLabel(__('features::general.attributes.in_filter')),
            Toggle::create('features-in_desc', $feature)->required()->setLabel(__('features::general.attributes.in_desc')),
            Toggle::create('features-main', $feature)->required()->setLabel(__('features::general.attributes.main')),
            Select::create('features-type', $feature)
                ->add(config('features.types', []))
                ->setDefaultValue(Feature::TYPE_SINGLE)
                ->setLabel(__('features::general.attributes.features-type'))
        );

        $form->fieldSetForLang(12)->add(
            InputForSlug::create('features-name', $feature)->required()->setLabel(__('features::general.attributes.features-name')),
            Slug::create('features-slug', $feature)->required()->setLabel(__('features::general.attributes.features-slug'))
        );

        $form->fieldSetForLang(12)->add(
            InputForSlug::create('name', $value)->required(),
            Slug::create('slug', $value)->required()
        );

        return $form;
    }

}
