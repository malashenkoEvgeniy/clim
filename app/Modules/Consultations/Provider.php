<?php

namespace App\Modules\Consultations;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Notifications\Types\NotificationType;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Consultations\Listeners\NewConsultationOrderNotification;
use App\Modules\Consultations\Models\Consultation;
use App\Modules\Consultations\Widgets\Button;
use App\Modules\Consultations\Widgets\Popup;
use CustomForm\Input;
use CustomMenu, CustomSettings, CustomRoles, Widget;
use App\Core\BaseProvider;

/**
 * Class Provider
 *
 * @package App\Modules\Consultations
 */
class Provider extends BaseProvider
{
    
    /**
     * Set custom presets
     */
    protected function presets()
    {
        $this->registerNotificationType(
            NewConsultationOrderNotification::NOTIFICATION_TYPE,
            NewConsultationOrderNotification::NOTIFICATION_ICON,
            NotificationType::COLOR_PURPLE
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
        $settings = CustomSettings::createAndGet('consultations', 'consultations::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('consultations::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        CustomMenu::get()->group()->block('forms', 'consultations::general.main-menu-block', 'fa fa-edit')
            ->link('consultations::general.menu', RouteObjectValue::make('admin.consultations.index'))
            ->addCounter(Consultation::whereActive(false)->count(), 'bg-green')
            ->additionalRoutesForActiveDetect(RouteObjectValue::make('admin.consultations.edit'));
        // Register role scopes
        CustomRoles::add('consultations', 'consultations::general.menu')->except(RoleRule::VIEW, RoleRule::STORE);
    }
    
    protected function afterBoot()
    {
        Widget::register(Popup::class, 'consultation-popup');
        Widget::register(Button::class, 'consultation-button');
    }
    
}
