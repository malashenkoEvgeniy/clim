<?php

namespace App\Modules\Wishlist;

use App\Core\BaseProvider;
use App\Core\ObjectValues\LinkObjectValue;
use App\Modules\Wishlist\Components\WishlistFacade;
use App\Modules\Wishlist\Listeners\LoginListener;
use App\Modules\Wishlist\Widgets\ActionBarButton;
use App\Modules\Wishlist\Widgets\MoveToWishlistButton;
use App\Modules\Wishlist\Widgets\TotalAmount;
use App\Modules\Wishlist\Widgets\WishlistMobileButton;
use App\Modules\Wishlist\Widgets\ProductButton;
use CustomForm\Input;
use CustomForm\Macro\Toggle;
use CustomSettings, Widget, Catalog, Schema, Event, CustomSiteMenu;
use Illuminate\Foundation\AliasLoader;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Wishlist
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('Wishlist', WishlistFacade::class);
    }

    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('wishlist', 'wishlist::general.settings-name');
        $settings->add(
            Input::create('per-page')->setLabel('wishlist::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        $settings->add(
            Toggle::create('only-cookies')
                ->setLabel('wishlist::settings.attributes.only-cookies'),
            ['required', 'bool']
        );
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        $menu = CustomSiteMenu::get('account-left');
        $menu->link(
            'wishlist::site.account-menu-link',
            LinkObjectValue::make(route('site.wishlist')),
            'icon-wishlist'
        );

        Event::listen('user.login', LoginListener::class);

        Widget::register(ProductButton::class, 'wishlist::product-button');
        Widget::register(ActionBarButton::class, 'wishlist::action-bar');
        Widget::register(MoveToWishlistButton::class, 'wishlist::move');
        Widget::register(WishlistMobileButton::class, 'mobile-top-wishlist-button');
        Widget::register(TotalAmount::class, 'wishlist::total-amount');
    }

}
