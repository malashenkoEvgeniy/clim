<?php

namespace App\Modules\ProductsServices;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\ProductsServices\Widgets\ProductPage;
use CustomRoles, CustomMenu;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\ProductsServices
 */
class Provider extends BaseProvider
{

    /**
     * Set custom presets
     */
    protected function presets()
    {
        $this->setModuleName('products_services');
    }

    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register role scopes
        CustomRoles::add('products_services', 'products_services::general.permission-name')
            ->except(RoleRule::VIEW);

        $group = CustomMenu::get()->group();
        $group
            ->block('content')
            ->link('products_services::menu.group', RouteObjectValue::make('admin.products-services.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.products-services.create'),
                RouteObjectValue::make('admin.products-services.edit')
            )
            ->setPermissionScope('products_services.index')
            ->setPosition(999);
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        \Widget::register(ProductPage::class, 'products-services::product-page');
    }
}
