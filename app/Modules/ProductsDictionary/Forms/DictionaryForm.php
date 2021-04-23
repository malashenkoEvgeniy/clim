<?php

namespace App\Modules\ProductsDictionary\Forms;

use App\Components\Settings\Models\Setting;
use App\Core\Interfaces\FormInterface;
use App\Modules\ProductsDictionary\Models\Dictionary;
use CustomForm\Builder\Form;
use CustomForm\Hidden;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use Illuminate\Database\Eloquent\Model;
use Nexmo\Call\Collection;

/**
 * Class DictionaryForm
 *
 * @package App\Core\Modules\ProductsDictionary\Forms
 */
class DictionaryForm implements FormInterface
{

    /**
     * @param  Model||null $model
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $dictionary = null): Form
    {
        $dictionary = Dictionary::oldest('position')->get();
        // Form
        $form = Form::create();
        $fieldSet = $form->fieldSet(12);
        $fieldName = trans('products_dictionary::admin.title');
        $needsLanguage = count(config('languages', [])) > 1;
        foreach (config('languages', new Collection()) as $language) {
            $setting = Setting::whereGroup('products_dictionary')->whereAlias($language->slug . '_title')->first();
            $fieldSet->add(
                Input::create($language->slug . '[products_dictionary_title]')
                    ->setDefaultValue($setting ? $setting->value : null)
                    ->setLabel($fieldName . ($needsLanguage ? ' (' . $language->name . ')' : ''))
                    ->required()
            );
        }
        $status = Setting::whereGroup('products_dictionary')->whereAlias('site_status')->first();
//        $selectStatus = Setting::whereGroup('products_dictionary')->whereAlias('select_status')->first();
        // Simple field set
        $fieldSet->add(
            Toggle::create('site_status')
                ->setLabel('products_dictionary::admin.site_status')
                ->setDefaultValue($status ? $status->value : 1),
//            Toggle::create('select_status')
//                ->setLabel('products_dictionary::admin.select_status')
//                ->setDefaultValue($selectStatus ? $selectStatus->value : 1)
            Hidden::create('select_status')->setDefaultValue(1)
        );
        $form->fieldSetForView('products_dictionary::admin.values.index', [
            'values' => $dictionary->isNotEmpty() ? $dictionary : null,
        ]);
        $form->buttons->doNotShowSaveAndAddButton();
        return $form;
    }

}
