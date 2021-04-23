<?php

namespace App\Modules\Reviews;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Reviews\Widgets\Reviews;
use App\Widgets\Admin\StatCard;
use Widget, CustomMenu, CustomSettings, CustomRoles;
use App\Core\BaseProvider;
use App\Modules\Reviews\Models\Review;

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
        CustomSettings::createAndGet('reviews', 'reviews::settings.group-name');
        // Register left menu block
        CustomMenu::get()->group()
            ->block('forms')
            ->link('reviews::general.menu', RouteObjectValue::make('admin.reviews.index'))
            ->addCounter(Review::whereActive(false)->count(), 'bg-orange')
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.reviews.edit'),
                RouteObjectValue::make('admin.reviews.create')
            );
        // Dashboard widget
        Widget::register(
            new StatCard(
                Review::class,
                'reviews::general.stat-widget-title',
                route('admin.reviews.index'),
                'reviews.index',
                StatCard::COLOR_AQUA,
                'ion-android-textsms'
            ),
            'reviews-count',
            'dashboard-fast-stat',
            2
        );
        // Register role scopes
        CustomRoles::add('reviews', 'reviews::general.menu')->except(RoleRule::VIEW);
    }
    
    protected function afterBoot()
    {
        Widget::register(Reviews::class, 'reviews');
    }
    
    public function initSitemap()
    {
        return [[
            'name' => trans('reviews::site.reviews'),
            'url' => route('site.reviews'),
        ]];
    }


    public function initSitemapXml()
    {
        $languages = config('languages', []);
        $items = [];
        /** @var Language $language */
        foreach($languages as $language){
            $prefix = $language->default ? '' : '/'.$language->slug;
            $items[] = [
                'url' => url($prefix . route('site.reviews', [] , false), [], isSecure())
            ];
        }

        return $items;
    }
    
}
