<?php

namespace App\Modules\Features\Forms;

use App\Core\Interfaces\FormInterface;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use App\Modules\Features\Models\Feature;
use CustomForm\Hidden;
use CustomForm\Macro\InputForSlug;
use CustomForm\Macro\Slug;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\Text;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FeatureForm
 *
 * @package App\Core\Modules\Features\Forms
 */
class FeatureForm implements FormInterface {

    /**
     * @param  Model|Feature|null $feature
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $feature = null): Form
    {
        $feature = $feature ?? new Feature;
        $form = Form::create();
        $form->fieldSet(6, FieldSet::COLOR_SUCCESS)->add(
            Toggle::create('in_filter', $feature)->required()->setLabel(__('features::general.attributes.in_filter')),
            Toggle::create('in_desc', $feature)->required()->setLabel(__('features::general.attributes.in_desc')),
            Toggle::create('main', $feature)->required()->setLabel(__('features::general.attributes.main')),
            Select::create('type', $feature)
                ->add(config('features.types', []))
                ->setDefaultValue(Feature::TYPE_SINGLE)
        );
        $form->fieldSetForLang(6)->add(
            InputForSlug::create('name', $feature)->required(),
            Slug::create('slug', $feature)->required()
        );
        if ($feature->exists) {
            $form->fieldSetForView('features::admin.values.index', [
                'values' => $feature->values,
                'feature' => $feature,
            ]);
        }
        return $form;
    }

}
