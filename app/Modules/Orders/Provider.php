<?php

namespace App\Modules\Orders;

use App\Core\BaseProvider;
use App\Core\Modules\Notifications\Types\NotificationType;
use App\Core\ObjectValues\LinkObjectValue;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderStatus;
use App\Modules\Orders\Widgets\Cart\Button;
use App\Modules\Orders\Widgets\Cart\ButtonSplash;
use App\Modules\Orders\Widgets\Cart\CartInCheckout;
use App\Modules\Orders\Widgets\Cart\MobileButton;
use App\Modules\Orders\Components\Cart\CartFacade;
use App\Modules\Orders\Listeners\OrderCreatedNotificationListener;
use App\Modules\Orders\Widgets\CheckoutButton;
use App\Modules\Orders\Widgets\DashboardOrders;
use App\Widgets\Admin\StatCard;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomForm\TinyMce;
use CustomSettings, CustomRoles, CustomMenu, Widget, CustomSiteMenu;
use Illuminate\Foundation\AliasLoader;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\SimpleCheckout
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Cart', CartFacade::class);

        $this->registerNotificationType(
            OrderCreatedNotificationListener::NOTIFICATION_TYPE,
            OrderCreatedNotificationListener::NOTIFICATION_ICON,
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
        $settings = CustomSettings::createAndGet('orders', 'orders::settings.group-name');
        $settings->add(
            Input::create('per-page')
                ->setType('number')
                ->required()
                ->setLabel('orders::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Input::create('per-page-for-user')
                ->setType('number')
                ->required()
                ->setLabel('orders::settings.attributes.per-page-for-user'),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Toggle::create('email-is-required')
                ->setDefaultValue(true)
                ->required()
                ->setLabel('orders::settings.attributes.email-is-required'),
            ['required', 'boolean']
        );
        $settings->add(
            TinyMce::create('address_for_self_delivery')
                ->required()
                ->setLabel('orders::settings.attributes.address_for_self_delivery'),
            ['required', 'string']
        );
        // Menu
        $block = CustomMenu::get()->group()
            ->block('orders', 'orders::general.menu.orders', 'fa fa-cart-plus')
            ->setPosition(-998);
        $block
            ->link(
                'orders::general.menu.statuses',
                RouteObjectValue::make('admin.orders-statuses.index')
            )
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.orders-statuses.edit'),
                RouteObjectValue::make('admin.orders-statuses.create')
            );
        $block
            ->link(
                'orders::general.menu.orders',
                RouteObjectValue::make('admin.orders.index')
            )
            ->addCounter(Order::whereStatusId(OrderStatus::newOrder()->id)->count(), 'bg-red')
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.orders.edit'),
                RouteObjectValue::make('admin.orders.show'),
                RouteObjectValue::make('admin.orders.create')
            );
        // Register role scopes
        CustomRoles::add('orders', 'orders::general.permission-name')->enableAll();

        Widget::register(DashboardOrders::class, 'dashboard-orders-widget', 'dashboard');
        Widget::register(
            new StatCard(
                Order::class,
                'orders::general.stat-widget-title',
                route('admin.orders.index'),
                'orders.index',
                StatCard::COLOR_RED,
                'ion-ios-cart'
            ),
            'orders-count',
            'dashboard-fast-stat',
            3
        );
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        // Register left menu block
        $menu = CustomSiteMenu::get('account-left');
        $menu->link(
            'orders::site.account-left-menu',
            LinkObjectValue::make(route('site.account.orders')),
            'icon-folder'
        );

        // Register mobile menu block
        $menu = CustomSiteMenu::get('account-mobile');
        $menu->link(
            'orders::site.account-left-menu',
            LinkObjectValue::make(route('site.account.orders')),
            'icon-folder'
        );
        Widget::register(CheckoutButton::class, 'orders::checkout-button');

        $menu = CustomSiteMenu::get('account-left');
        $menu->link(
            'orders::site.cart',
            LinkObjectValue::make(route('site.cart.index')),
            'icon-shopping'
        );
        Widget::register(Button::class, 'orders::cart::add-button');
        Widget::register(ButtonSplash::class, 'orders::cart::splash-button');
        Widget::register(CartInCheckout::class, 'orders::cart::checkout');
        Widget::register(MobileButton::class, 'mobile-top-cart-button');
    }

}
