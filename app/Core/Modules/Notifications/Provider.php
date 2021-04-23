<?php

namespace App\Core\Modules\Notifications;

use App\Core\BaseProvider;
use App\Core\Modules\Notifications\Listeners\ErrorListener;
use App\Core\Modules\Notifications\Types\NotificationType;
use CustomForm\Input;
use CustomSettings, CustomRoles;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Core\Modules\Notifications
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        $this->registerNotificationType(
            ErrorListener::NOTIFICATION_TYPE,
            ErrorListener::NOTIFICATION_ICON,
            NotificationType::COLOR_RED
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
        $settings = CustomSettings::createAndGet('notifications', 'notifications::general.settings-name');
        $settings->add(
            Input::create('per-page-in-widget')->setLabel('notifications::settings.attributes.per-page-in-widget'),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Input::create('per-page')->setLabel('notifications::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
    }

}
