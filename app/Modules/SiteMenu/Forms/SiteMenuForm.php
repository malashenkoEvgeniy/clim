<?php

namespace App\Modules\SiteMenu\Forms;

use App\Components\Form\ObjectValues\ModelForSelect;
use App\Core\Interfaces\FormInterface;
use App\Modules\SiteMenu\Models\SiteMenu;
use CustomForm\Builder\FieldSet;
use CustomForm\Builder\Form;
use CustomForm\Hidden;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use Illuminate\Database\Eloquent\Model;
use Route;

/**
 * Class SiteMenuForm
 *
 * @package App\Core\Modules\Administrators\Forms
 */
class SiteMenuForm implements FormInterface
{
    
    /**
     * @param  Model|SiteMenu|null $siteMenu
     * @return Form
     * @throws \App\Exceptions\WrongParametersException
     */
    public static function make(?Model $siteMenu = null): Form
    {
        $siteMenu = $siteMenu ?? new SiteMenu();
        $form = Form::create();
        // Field set with languages tabs
        $form->fieldSetForLang(7)->add(
            Input::create('name', $siteMenu)->required(),
            Input::create('slug', $siteMenu)
                ->setLabel('validation.attributes.url')
                ->required(),
            Select::create('slug_type', $siteMenu)->add(
                [
                    SiteMenu::INTERNAL_LINK => __('site_menu::general.internal'),
                    SiteMenu::EXTERNAL_LINK => __('site_menu::general.external'),
                ]
            )->setLabel(__('site_menu::general.slug_type'))
        );
        $fieldSet = $form->fieldSet(5, FieldSet::COLOR_SUCCESS);

        $place = Route::current()->parameter('place');
        if ($place === SiteMenu::PLACE_HEADER) {
            $fieldSet->add(
                Select::create('parent_id', $siteMenu)
                    ->add(SiteMenu::topLevelForSelect($place))
                    ->setDoNotShowElement($siteMenu->id ?? null)
                    ->setPlaceholder('&mdash;')
            );
        }
        $fieldSet->add(
            Toggle::create('active', $siteMenu)->required(),
            Toggle::create('noindex', $siteMenu)->required(),
            Toggle::create('nofollow', $siteMenu)->required(),
            Hidden::create('place')->setLabel(false)->setValue(\Route::current()->parameter('place'))
        );
        return $form;
    }
    
}
