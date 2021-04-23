<?php

namespace App\Modules\Import;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Import\Widgets\Courses;
use App\Modules\Import\Widgets\CoursesHistory;
use CustomMenu, CustomRoles;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Home
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
        CustomMenu::get()->group()->block('catalog')
            ->link('import::admin.menu', RouteObjectValue::make('admin.import.index'));
        // Register role scopes
        CustomRoles::add('import', 'import::admin.permission-name')
            ->only(RoleRule::STORE, RoleRule::INDEX);
        
        \Widget::register(Courses::class, 'import::courses');
        \Widget::register(CoursesHistory::class, 'import::courses-history');
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
    }
    
}
