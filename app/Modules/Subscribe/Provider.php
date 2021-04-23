<?php

namespace App\Modules\Subscribe;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Subscribe\Models\Subscriber;
use App\Modules\Subscribe\Widgets\SubscribeForm;
use CustomForm\Input;
use CustomMenu, CustomSettings, CustomRoles, Widget;
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
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('subscribe', 'subscribe::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('subscribe::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Input::create('history-per-page')->setLabel('subscribe::settings.attributes.history-per-page'),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        $menu = CustomMenu::get()->group()->block('subscribe', 'subscribe::general.menu-main-block', 'fa fa-envelope');
        $menu
            ->link('subscribe::general.menu', RouteObjectValue::make('admin.subscribers.index'))
            ->addCounter(Subscriber::whereActive(false)->count(), 'bg-maroon')
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.subscribers.edit'),
                RouteObjectValue::make('admin.subscribers.create')
            );
        $menu->link('subscribe::general.menu-mailing', RouteObjectValue::make('admin.subscribe.mailing'));
        $menu->link('subscribe::general.menu-history', RouteObjectValue::make('admin.subscribe.history'));
        // Register role scopes
        CustomRoles::add('subscribe', 'subscribe::general.menu')->except(RoleRule::VIEW);
        CustomRoles::add('subscribe', 'subscribe::general.rule-subscribe')
            ->only(RoleRule::INDEX, RoleRule::STORE)
            ->addCustomPolicy('history', RoleRule::INDEX);
        CustomRoles::add('subscribers', 'subscribe::general.menu')
            ->except(RoleRule::VIEW);
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(SubscribeForm::class, 'subscribe::form');
    }
    
}
