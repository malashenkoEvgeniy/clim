<?php

namespace App\Modules\ProductsDictionary;

use App\Core\BaseProvider;
use App\Modules\ProductsDictionary\Widgets\Admin\DictionaryFormOnOrderPage;
use App\Modules\ProductsDictionary\Widgets\Admin\DictionaryFormOnOrderViewPage;
use App\Modules\ProductsDictionary\Widgets\Admin\DictionaryFormOnProductPage;
use App\Modules\ProductsDictionary\Widgets\DictionaryDisplayText;
use App\Modules\ProductsDictionary\Widgets\DictionaryMail;
use App\Modules\ProductsDictionary\Widgets\Site\DictionaryInCart;
use App\Modules\ProductsDictionary\Widgets\Site\DictionaryInChechout;
use App\Modules\ProductsDictionary\Widgets\Site\DictionarySelectOnProductPage;
use CustomSettings, CustomRoles, Widget;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\ProductsDictionary
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
        CustomSettings::createAndGet('products_dictionary', 'products_dictionary::admin.settings-name');
        // Register role scopes
        CustomRoles::add('products_dictionary', 'products_dictionary::admin.permission-name');

        $status = config('db.products_dictionary.site_status');
        if(isset($status) && $status) {
            Widget::register(DictionaryFormOnProductPage::class, 'products_dictionary::choose-in-product');
            Widget::register(DictionaryFormOnOrderPage::class, 'products_dictionary::choose-in-order');
            Widget::register(DictionaryFormOnOrderViewPage::class, 'products_dictionary::choose-in-order-view');
            Widget::register(DictionaryDisplayText::class, 'products_dictionary::display-text');
        }
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        $status = config('db.products_dictionary.site_status');
        if(isset($status) && $status) {
            Widget::register(DictionarySelectOnProductPage::class, 'products_dictionary::show-in-product');
            Widget::register(DictionaryInCart::class, 'products_dictionary::show-in-cart');
            Widget::register(DictionaryInChechout::class, 'products_dictionary::show-in-checkout');
            Widget::register(DictionaryMail::class, 'products_dictionary::mail-item');
            Widget::register(DictionaryDisplayText::class, 'products_dictionary::display-text');
        }
    }

}
