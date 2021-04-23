<?php

namespace App\Core\Modules\Translates;

use App\Core\BaseProvider;
use CustomSettings, CustomRoles, Schema, Lang, CustomMenu;
use App\Core\Modules\Translates\Models\Translate;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use CustomForm\Input;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Translates
 */
class Provider extends BaseProvider
{

    public $_translates;

    /**
     * Set custom presets
     */
    protected function presets()
    {
    }

    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // set translates from DB
        $this->setCustomTranslates();
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('translates', 'translates::general.settings-name');
        $settings->add(
            Input::create('per-page')
                ->setLabel('translates::settings.attributes.per-page')
                ->required(),
            ['required', 'integer', 'min:1']
        );
       CustomMenu::get()->group('system', null, 1)
            ->link(
                'translates::general.menu',
                RouteObjectValue::make('admin.translates.index', ['place' => 'general']),
                'fa fa-magic',
                [
                    RouteObjectValue::make('admin.translates.index', ['place' => 'site']),
                    RouteObjectValue::make('admin.translates.index', ['place' => 'admin']),
                    RouteObjectValue::make('admin.translates.module'),
                ]
            )
            ->setPermissionScope('translates.index');
        // Register role scopes
        CustomRoles::add('translates', 'translates::general.menu')
            ->only(RoleRule::INDEX, RoleRule::UPDATE)
            ->addCustomPolicy('translates', RoleRule::UPDATE);
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        // set translates from DB
        $this->setCustomTranslates();
    }

    protected function setCustomTranslates()
    {
        if (Schema::hasTable('translates')) {
            if (empty($this->_translates)) {
                $translatesWithLangKey = [];
                Translate::select('name', 'text', 'language', 'module')->get()
                    ->map(function (Translate $translate) use (&$translatesWithLangKey) {
                        return $translatesWithLangKey[$translate->module][$translate->language][$translate->name] = $translate->text;
                    })->toArray();
                $this->_translates = $translatesWithLangKey;
            }

            foreach ($this->_translates as $module => $languages) {
                foreach ($languages as $lang => $translates) {
                    Lang::addLines($translates, $lang, $module);
                }
            }
        }
    }

}
