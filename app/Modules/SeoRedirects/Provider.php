<?php

namespace App\Modules\SeoRedirects;

use App\Core\BaseProvider;
use App\Modules\SeoRedirects\Middleware\Seo;
use Illuminate\Contracts\Http\Kernel;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\ObjectValues\RouteObjectValue;
use CustomForm\Input;
use CustomSettings, CustomRoles, CustomMenu;

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
        // Register module configurable settings
        $settings = CustomSettings::createAndGet('seo_redirects', 'seo_redirects::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('seo_redirects::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        CustomMenu::get()->group()->block('seo', 'seo_redirects::general.main-menu-block', 'fa fa-rocket')
            ->link('seo_redirects::general.menu', RouteObjectValue::make('admin.seo_redirects.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.seo_redirects.edit'),
                RouteObjectValue::make('admin.seo_redirects.create')
            );
        // Register role scopes
        CustomRoles::add('seo_redirects', 'seo_redirects::general.permission-name')
            ->except(RoleRule::VIEW);
    }


    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        $this->app->make(Kernel::class)->pushMiddleware(Seo::class);
    }

}
