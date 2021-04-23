<?php

namespace App\Modules\SeoLinks;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\BaseProvider;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\SeoLinks\Models\SeoLink;
use CustomForm\Input;
use CustomMenu, CustomSettings, CustomRoles, URL, Seo;

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
        $settings = CustomSettings::createAndGet('seo_links', 'seo_links::settings.group-name');
        $settings->add(
            Input::create('per-page')->setLabel('seo_links::settings.attributes.per-page'),
            ['required', 'integer', 'min:1']
        );
        // Register left menu block
        CustomMenu::get()->group()->block('seo', 'seo_links::general.main-menu-block', 'fa fa-rocket')
            ->link('seo_links::general.menu', RouteObjectValue::make('admin.seo_links.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.seo_links.edit'),
                RouteObjectValue::make('admin.seo_links.create')
            );
        // Register role scopes
        CustomRoles::add('seo_links', 'seo_links::general.permission-name')
            ->except(RoleRule::VIEW);
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        $this->app->booted(function () {
            if (\Schema::hasTable((new SeoLink)->getTable())) {
                $host = array_get($_SERVER, 'HTTP_HOST', env('APP_URL', ''));
                $urlParts = explode($host, URL::current());
                array_shift($urlParts);
                $url = implode($host, $urlParts);
                $urlParts = explode('?', $url);
                $url = array_shift($urlParts);
                $url = str_replace('/' . \Lang::getLocale() . '/', '/', $url);
    
                $seoLink = SeoLink::whereUrl($url)->whereActive(true)->first();
                if ($seoLink) {
                    Seo::site()->setMetaByLink($seoLink->current);
                }
            }
        });
    }
    
}
