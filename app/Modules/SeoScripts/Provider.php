<?php

namespace App\Modules\SeoScripts;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Core\BaseProvider;
use App\Modules\SeoScripts\Widgets\SeoMetrics;
use CustomMenu, CustomRoles, Widget;


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
        // Register left menu block
        CustomMenu::get()->group()
            ->block('seo', 'seo_scripts::general.main-menu-block', 'fa fa-rocket')
            ->link('seo_scripts::general.menu', RouteObjectValue::make('admin.seo_scripts.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.seo_scripts.edit'),
                RouteObjectValue::make('admin.seo_scripts.create')
            );
        // Register role scopes
        CustomRoles::add('seo_scripts', 'seo_scripts::general.permission-name')
            ->except(RoleRule::VIEW);
    }


    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(SeoMetrics::class, 'seo-metrics');
    }


}
