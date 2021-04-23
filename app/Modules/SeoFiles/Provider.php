<?php

namespace App\Modules\SeoFiles;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SeoFiles\Models\SeoFile;
use CustomMenu, CustomRoles, Config;

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
        // Register disk settings
        Config::set('filesystems.disks.' . SeoFile::DISK, [
            'driver' => 'local',
            'root' => public_path('site'),
            'url' => '/',
        ]);
        // Register left menu block
        CustomMenu::get()->group()->block('seo', 'seo_files::general.main-menu-block', 'fa fa-rocket')
            ->link('seo_files::general.menu', RouteObjectValue::make('admin.seo_files.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.seo_files.edit'),
                RouteObjectValue::make('admin.seo_files.create')
            );
        // Register role scopes
        CustomRoles::add('seo_files', 'seo_files::general.permission-name')
            ->except(RoleRule::VIEW);
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
    }
    
}
