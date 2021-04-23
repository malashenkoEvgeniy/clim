<?php

namespace App\Core\Modules\Dashboard;

use App\Components\Menu\Group;
use App\Core\ObjectValues\RouteObjectValue;
use CustomMenu;
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
     * Register widgets and menu
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        // Register menu element
        CustomMenu::get()->group(Group::INVISIBLE_GROUP_TYPE, null, -99999)
            ->link('dashboard::general.menu.dashboard', RouteObjectValue::make('admin.dashboard'), 'fa fa-dashboard')
            ->setCanBeShowed(true)
            ->setPosition(-999999);
    }
    
}
