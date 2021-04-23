<?php

namespace App\Modules\Callback;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Notifications\Types\NotificationType;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Callback\Listeners\NewCallbackOrderNotification;
use App\Modules\Callback\Models\Callback;
use App\Modules\Callback\Widgets\Button;
use App\Modules\Callback\Widgets\Popup;
use App\Modules\Callback\Widgets\Row;
use CustomForm\Input;
use CustomMenu, CustomSettings, CustomRoles, Widget;
use App\Core\BaseProvider;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Callback
 */
class Provider extends BaseProvider
{
    
    /**
     * Set custom presets
     */
    protected function presets()
    {
        $this->registerNotificationType(
            NewCallbackOrderNotification::NOTIFICATION_TYPE,
            NewCallbackOrderNotification::NOTIFICATION_ICON,
            NotificationType::COLOR_YELLOW
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
        $settings = CustomSettings::createAndGet('callback', 'callback::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('callback::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        CustomMenu::get()->group()->block('forms', 'callback::general.main-menu-block', 'fa fa-edit')
            ->link('callback::general.menu', RouteObjectValue::make('admin.callback.index'))
            ->addCounter(Callback::whereActive(false)->count(), 'bg-aqua')
            ->additionalRoutesForActiveDetect(RouteObjectValue::make('admin.callback.edit'));
        // Register role scopes
        CustomRoles::add('callback', 'callback::general.menu')->except(RoleRule::VIEW, RoleRule::STORE);
    }
    
    protected function afterBoot()
    {
        Widget::register(Popup::class, 'callback-popup');
        Widget::register(Button::class, 'callback-button');
        Widget::register(Row::class, 'callback-row');
    }
    
}
