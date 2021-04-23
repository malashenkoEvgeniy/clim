<?php

namespace App\Modules\SeoTemplates;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use App\Core\BaseProvider;
use App\Modules\SeoTemplates\Models\SeoTemplate;
use CustomMenu, CustomRoles, Seo;

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
        CustomMenu::get()->group()->block('seo', 'seo_templates::general.main-menu-block', 'fa fa-rocket')
            ->link('seo_templates::general.menu', RouteObjectValue::make('admin.seo_templates.index'))
            ->additionalRoutesForActiveDetect(RouteObjectValue::make('admin.seo_templates.edit'));
        // Register role scopes
        CustomRoles::add('seo_templates', 'seo_templates::general.permission-name')
            ->except(RoleRule::VIEW, RoleRule::STORE, RoleRule::DELETE);
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        if (\Schema::hasTable((new SeoTemplate)->getTable())) {
            $this->app->booted(function () {
                foreach (SeoTemplate::all() as $template) {
                    Seo::site()->addAvailableTemplate($template->alias, $template->current);
                }
            });
        }
    }
    
}
