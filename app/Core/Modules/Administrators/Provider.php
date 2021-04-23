<?php

namespace App\Core\Modules\Administrators;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\Admin;
use App\Core\Modules\Administrators\Widgets\AuthMenu;
use App\Core\Modules\Notifications\Widgets\Notifications;
use App\Core\ObjectValues\RouteObjectValue;
use CustomForm\Input;
use Widget, CustomMenu, Config, CustomSettings;

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
        $this->setTranslationsNamespace('admins');
        $this->setViewNamespace('admins');
        // Register administrators auth system
        Config::set(
            'auth.guards.admin', [
                'driver' => 'session',
                'provider' => 'admins',
            ]
        );
        Config::set(
            'auth.providers.admins', [
                'driver' => 'eloquent',
                'model' => Admin::class,
            ]
        );
        Config::set(
            'auth.passwords.admins', [
                'provider' => 'admins',
                'table' => 'password_resets',
                'expire' => 60,
            ]
        );
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('admins', 'admins::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('admins::settings.attributes.per-page'),
            ['required', 'integer', 'min:1', 'max:100']
        );
        $settings->add(
            Input::create('roles-per-page')->setLabel('admins::settings.attributes.roles-per-page'),
            ['required', 'integer', 'min:1', 'max:100']
        );
        // Register left menu block
        $block = CustomMenu::get()->group('system')
            ->block('admins', 'admins::menu.block', 'fa fa-user-secret');
        $block->link(
            'admins::menu.roles',
            RouteObjectValue::make('admin.roles.index'),
            [
                RouteObjectValue::make('admin.roles.create'),
                RouteObjectValue::make('admin.roles.edit'),
            ]
        );
        $block->link(
            'admins::menu.admins',
            RouteObjectValue::make('admin.admins.index'),
            [
                RouteObjectValue::make('admin.admins.create'),
                RouteObjectValue::make('admin.admins.edit'),
            ]
        );
        // Register admin personal menu elements
        $menu = CustomMenu::get('admin-menu')->group();
        $menu->link('admins::user-menu.personal-data', RouteObjectValue::make('admin.account.view'))
            ->setCanBeShowed(true);
        $menu->link('admins::user-menu.change-password', RouteObjectValue::make('admin.account.password'))
            ->setCanBeShowed(true);
        $menu->link('admins::user-menu.change-avatar', RouteObjectValue::make('admin.account.avatar'))
            ->setCanBeShowed(true);
        // Menu component
        Widget::register(Notifications::class, 'notifications', 'header');
        Widget::register(AuthMenu::class, 'auth-menu', 'header');
    }
    
}
