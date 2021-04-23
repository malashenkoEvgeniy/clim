<?php

namespace App\Modules\ProductsAvailability;

use App\Core\Modules\Notifications\Types\NotificationType;
use App\Modules\ProductsAvailability\Models\ProductsAvailability as ProductsAvailabilityModel;
use App\Modules\ProductsAvailability\Widgets\ProductsAvailability;
use App\Modules\ProductsAvailability\Widgets\ProductsAvailabilityClick;
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
 * @package App\Modules\ProductsAvailability
 */
class Provider extends BaseProvider
{

    /**
    * Set custom presets
    */
    protected function presets()
    {
        $this->registerNotificationType(
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
        $settings = CustomSettings::createAndGet('products_availability', 'products-availability::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('products-availability::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        $group = CustomMenu::get()->group();
        $group
            ->block('catalog')
            ->link('products-availability::general.menu', RouteObjectValue::make('admin.products_availability.index'))
            ->addCounter(ProductsAvailabilityModel::whereNull('deleted_at')->count(), 'bg-blue')
            ->additionalRoutesForActiveDetect(RouteObjectValue::make('admin.products_availability.edit'));
        // Register role scopes
        CustomRoles::add('products_availability', 'products-availability::general.menu')
            ->except(RoleRule::VIEW, RoleRule::STORE);
    }


    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(ProductsAvailabilityClick::class, 'products-availability::button');
        Widget::register(ProductsAvailability::class, 'products-availability');
    }

}
