<?php

namespace App\Modules\FastOrders;

use App\Core\Modules\Notifications\Types\NotificationType;
use App\Modules\FastOrders\Listeners\NewFastOrder;
use App\Modules\FastOrders\Widgets\FastOrderClick;
use App\Modules\FastOrders\Widgets\FastOrder;
use App\Modules\FastOrders\Models\FastOrder as FastOrderModel;
use Widget;
use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use CustomForm\Input;
use CustomSettings, CustomRoles, CustomMenu;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\FastOrder
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        $this->registerNotificationType(
            NewFastOrder::NOTIFICATION_TYPE,
            NewFastOrder::NOTIFICATION_ICON,
            NotificationType::COLOR_GREEN
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
        $settings = CustomSettings::createAndGet('fast_orders', 'fast_orders::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('fast_orders::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        $group = CustomMenu::get()->group();
        $group
            ->block('orders')
            ->link('fast_orders::general.menu', RouteObjectValue::make('admin.fast_orders.index'))
            ->addCounter(FastOrderModel::whereActive(false)->count(), 'bg-blue')
            ->additionalRoutesForActiveDetect(RouteObjectValue::make('admin.fast_orders.edit'));
        // Register role scopes
        CustomRoles::add('fast_orders', 'fast_orders::general.menu')
            ->except(RoleRule::VIEW, RoleRule::STORE);
    }

    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
       Widget::register(FastOrderClick::class, 'fast-orders::button');
       Widget::register(FastOrder::class, 'orders-one-click-buy');
    }

}
