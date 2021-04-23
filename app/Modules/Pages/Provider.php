<?php

namespace App\Modules\Pages;

use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Pages\Models\Page;
use App\Modules\Pages\Models\PageTranslates;
use CustomMenu, Widget, CustomRoles;
use App\Core\BaseProvider;
use App\Modules\Pages\Widgets\PageMenu;
use Illuminate\Database\Eloquent\Builder;

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
                ->block('content', 'pages::general.menu-block', 'fa fa-files-o')
                ->link('pages::general.menu', RouteObjectValue::make('admin.pages.index'))
                ->additionalRoutesForActiveDetect(
                        RouteObjectValue::make('admin.pages.edit'), RouteObjectValue::make('admin.pages.create')
        );
        // Register role scopes
        CustomRoles::add('pages', 'pages::general.menu')->except(RoleRule::VIEW);
    }

    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        Widget::register(PageMenu::class, 'pages-menu');
    }
    
    public function initSitemap()
    {
        $pages = Page::with('current')
            ->where(function (Builder $builder) {
                $builder->where('parent_id', 0)->orWhereNull('parent_id');
            })
            ->oldest('position')
            ->whereActive(true)
            ->get();
        
        $tree = $this->buildSitemapTree($pages);
        return $tree;
    }
    
    protected function buildSitemapTree($pages)
    {
        $items = [];
        foreach ($pages as $page) {
            $item = [
                'name' => $page->current->name,
                'url' => route('site.page', ['slug' => $page->current->slug]),
            ];
            if (count($page->children)) {
                $item['items'] = $this->buildSitemapTree($page->children);
            }
            $items[] = $item;
        }
        return $items;
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
        PageTranslates::whereHas('row', function (Builder $builder){
            $builder->where('active', true);
        })->get()->each(function (PageTranslates $page) use (&$items, &$default_language) {
            $prefix = ($default_language == $page->language) ? '' : '/'.$page->language;
            $items[] = [
                'url' => url($prefix . route('site.page', ['slug' => $page->slug], false), [], isSecure()),
            ];
        });
        return $items;
    }

}
