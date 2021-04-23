<?php

namespace App\Core\Modules\Languages;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Widgets\LanguageTrigger;
use App\Core\ObjectValues\RouteObjectValue;
use CustomMenu, CustomRoles, Widget;
use App\Core\BaseProvider;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Index
 */
class Provider extends BaseProvider
{
    
    /**
     * Set custom presets
     */
    protected function presets()
    {
        $this->setConfigNamespace('langs');
        $this->setTranslationsNamespace('langs');
    }
    
    /**
     * Register widgets and menu
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        $languages = config('languages', []);
        if ($languages && is_array($languages) && count($languages) > 1) {
            CustomMenu::get()->group('system', null, 999)
                ->link('langs::general.menu', RouteObjectValue::make('admin.languages.index'), 'fa fa-flag')
                ->setPermissionScope('langs.index');
            // Register role scopes
            CustomRoles::add('langs', 'langs::general.menu')
                ->only(RoleRule::INDEX, RoleRule::UPDATE)
                ->addCustomPolicy('translit', RoleRule::UPDATE)
                ->addCustomPolicy('defaultLanguage', RoleRule::UPDATE);
        }
    }
    
    protected function afterBoot()
    {
        Widget::register(LanguageTrigger::class, 'languages::trigger');
    }
    
}
