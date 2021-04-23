<?php

namespace App\Core\Modules\Settings;

use App\Components\Delivery\NovaPoshta;
use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use CustomForm\Input;
use CustomForm\Macro\ColorPicker;
use CustomForm\Macro\Toggle;
use CustomForm\Select;
use CustomForm\WysiHtml5;
use CustomMenu, CustomRoles, CustomSettings;

/**
 * Class Provider
 * Settings service provider
 *
 * @package App\Core\Modules\Settings
 */
class Provider extends BaseProvider
{
    
    protected function presets()
    {
    }
    
    /**
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register menu
        CustomMenu::get()->group('system', 'settings::general.menu-system', 9999)
            ->link('settings::general.menu', RouteObjectValue::make('admin.settings.index'), 'fa fa-cogs')
            ->setPosition(9999999)
            ->additionalRoutesForActiveDetect(RouteObjectValue::make('admin.settings.group'));
        // Register role scopes
        CustomRoles::add('settings', 'settings::general.menu')
            ->only(RoleRule::INDEX, RoleRule::UPDATE, RoleRule::VIEW)
            ->addCustomPolicy('group', RoleRule::UPDATE);
    
        $this->liqPaySettings();
        CustomSettings::createAndGet('nova-poshta', 'settings::nova-poshta.settings-name', -9999);
        $this->logoSettings();
        $this->watermarkSettings();
        $this->slogan();
        $this->colorsSchema();
    }
    
    /**
     * @throws \App\Exceptions\WrongParametersException
     */
    private function liqPaySettings(): void
    {
        $settings = CustomSettings::createAndGet('liqpay', 'settings::liqpay.settings-name');
        $settings->add(
            Input::create('public-key')->setLabel('settings::liqpay.public-key'),
            ['nullable', 'string']
        );
        $settings->add(
            Input::create('private-key')->setLabel('settings::liqpay.private-key'),
            ['nullable', 'string']
        );
        $settings->add(
            Toggle::create('test')->setLabel('settings::liqpay.test')->required(),
            ['required', 'boolean']
        );
    }
    
    /**
     * @throws \App\Exceptions\WrongParametersException
     */
    private function logoSettings(): void
    {
        CustomSettings::createAndGet('logo', 'settings::logo.settings-name', -9999);
    }

    private function watermarkSettings(): void
    {
        CustomSettings::createAndGet('watermark', 'settings::watermark.settings-name', -9999);
    }
    
    /**
     * @throws \App\Exceptions\WrongParametersException
     */
    private function slogan(): void
    {
        CustomSettings::createAndGet('basic')
            ->add(
                WysiHtml5::create('slogan')
                    ->setLabel('settings::general.slogan')
                    ->setHelp('settings::general.slogan-info')
            );
    }
    
    /**
     * @throws \App\Exceptions\WrongParametersException
     */
    private function colorsSchema(): void
    {
        $settings = CustomSettings::createAndGet('colors', 'settings::general.colors.settings');
        
        $colorRule = 'regex:/^#[a-zA-Z0-9]{6}$/i';
        
        $settings->add(
            Input::create('main')
                ->setType('color')
                ->setDefaultValue('#60bc4f')
                ->setLabel('settings::general.colors.main')
                ->required(),
            ['required', $colorRule]
        );
        $settings->add(
            Input::create('main-lighten')
                ->setType('color')
                ->setDefaultValue('#68ca56')
                ->setLabel('settings::general.colors.main-lighten')
                ->required(),
            ['required', $colorRule]
        );
        $settings->add(
            Input::create('main-darken')
                ->setType('color')
                ->setDefaultValue('#59ad49')
                ->setLabel('settings::general.colors.main-darken')
                ->required(),
            ['required', $colorRule]
        );
        $settings->add(
            Input::create('secondary')
                ->setType('color')
                ->setDefaultValue('#f7931d')
                ->setLabel('settings::general.colors.secondary')
                ->required(),
            ['required', $colorRule]
        );
        $settings->add(
            Input::create('secondary-lighten')
                ->setType('color')
                ->setDefaultValue('#f7b21d')
                ->setLabel('settings::general.colors.secondary-lighten')
                ->required(),
            ['required', $colorRule]
        );
        $settings->add(
            Input::create('secondary-darken')
                ->setType('color')
                ->setDefaultValue('#e84d1a')
                ->setLabel('settings::general.colors.secondary-darken')
                ->required(),
            ['required', $colorRule]
        );
    }
    
}
