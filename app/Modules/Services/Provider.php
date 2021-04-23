<?php

namespace App\Modules\Services;

use App\Core\BaseProvider;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Services\Models\ServicesRubric;
use App\Modules\Services\Models\ServicesRubricTranslates;
use App\Modules\Services\Models\ServiceTranslates;
use App\Modules\Services\Widgets\ServicesRubrics;
use Widget, CustomMenu, CustomSettings, CustomRoles;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Services
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
        // Create menu items

        CustomMenu::get()->group()
            ->block('services', 'services::general.menu-block', 'fa fa-files-o')
            ->link('services::general.menu', RouteObjectValue::make('admin.services.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.services.edit'), RouteObjectValue::make('admin.services.create'),
                RouteObjectValue::make('admin.services_rubrics.index')
            );
        CustomMenu::get()->group()
            ->block('services', 'services::general.menu-block', 'fa fa-files-o')
            ->link('Категории услуг', RouteObjectValue::make('admin.services_rubrics.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.services.edit'), RouteObjectValue::make('admin.services.create'),
                RouteObjectValue::make('admin.services_rubrics.index')
            );

        // Register role scopes
        CustomRoles::add('services', 'services::general.permission-name');
        CustomRoles::add('rubrics', 'rubrics::general.permission-name');
    }

    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(ServicesRubrics::class, 'services-rubrics');
    }

    public function initSitemapXml()
    {
        $languages = config('languages', []);
        $default_language = null;
        /** @var Language $language */
        foreach($languages as $language){
            if($language->default){
                $default_language = $language->slug;
            }
        }

        $items = [];
        ServicesRubricTranslates::whereHas('row', function (\Illuminate\Database\Eloquent\Builder $builder){
            $builder->where('active', true);
        })->get()->each(function (ServicesRubricTranslates $servicesRubric) use (&$items, &$default_language) {
            $prefix = ($default_language == $servicesRubric->language) ? '' : '/'.$servicesRubric->language;
            $items[] = [
                'url' => url($prefix . route('site.page', ['slug' => $servicesRubric->slug], false), [], isSecure()),
            ];
        });

        ServiceTranslates::whereHas('row', function (\Illuminate\Database\Eloquent\Builder $builder){
            $builder->where('active', true);
        })->get()->each(function (ServiceTranslates $service) use (&$items, &$default_language) {
            $prefix = ($default_language == $service->language) ? '' : '/'.$service->language;
            $items[] = [
                'url' => url($prefix . route('site.page', ['slug' => $service->slug], false), [], isSecure()),
            ];
        });
        return $items;
    }

}
