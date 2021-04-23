<?php

namespace App\Core\Modules\SystemPages;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use CustomMenu, CustomRoles;
use App\Core\BaseProvider;

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
        CustomMenu::get()->group()->block('content', 'system_pages::general.menu-block')
            ->link('system_pages::general.menu', RouteObjectValue::make('admin.system_pages.index'))
            ->additionalRoutesForActiveDetect(RouteObjectValue::make('admin.system_pages.edit'));
        // Register role scopes
        CustomRoles::add('system_pages', 'system_pages::general.menu')
            ->only(RoleRule::INDEX, RoleRule::UPDATE);
    }
    
}
