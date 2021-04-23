<?php

namespace App\Modules\Categories;

use App\Core\BaseProvider;
use App\Core\Modules\Administrators\Models\RoleRule;
use App\Core\Modules\Languages\Models\Language;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Categories\Components\Category;
use App\Modules\Categories\Models\Category as CategoryModel;
use App\Modules\Categories\Models\CategoryTranslates;
use App\Modules\Categories\Widgets\CategoriesFooter;
use App\Modules\Categories\Widgets\CategoriesImagesKids;
use App\Modules\Categories\Widgets\CategoriesMainMenuInner;
use App\Modules\Categories\Widgets\CategoriesFilter;
use App\Modules\Categories\Widgets\CategoriesFilterKids;
use App\Modules\Categories\Widgets\CategoriesList;
use App\Modules\Categories\Widgets\CategoriesMainMenu;
use App\Modules\Categories\Widgets\CategoriesMobileMenu;

use App\Modules\Products\Models\ProductGroupFeatureValue;
use DB, ProductsFilter;
use App\Modules\Features\Models\Feature;
use App\Modules\Brands\Provider as BrandProvider;
use App\Modules\Products\Widgets\Site\ProductFilter;

use CustomRoles, CustomMenu, Widget, Catalog;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Provider
 * Module configuration class
 *
 * @package App\Modules\Catalog
 */
class Provider extends BaseProvider
{
    
    /**
     * Set custom presets
     */
    protected function presets()
    {
        Catalog::loadCategory(new Category());
    }
    
    /**
     * Register widgets and menu for admin panel
     *
     * @throws \App\Exceptions\WrongParametersException
     */
    protected function afterBootForAdminPanel()
    {
        $group = CustomMenu::get()->group();
        $group
            ->block('catalog')
            ->link('categories::menu.categories', RouteObjectValue::make('admin.categories.index'))
            ->additionalRoutesForActiveDetect(
                RouteObjectValue::make('admin.categories.create'),
                RouteObjectValue::make('admin.categories.edit')
            );
        // Register role scopes
        CustomRoles::add('categories', 'categories::general.permission-name')
            ->except(RoleRule::VIEW);
        
        Widget::register(CategoriesList::class, 'categories::list-for-product');
    }
    
    /**
     * Register module widgets and menu elements here for client side of the site
     */
    protected function afterBoot()
    {
        CategoryModel::dump();
        
        Widget::register(CategoriesFilter::class, 'categories::in-filter');
        Widget::register(CategoriesFilterKids::class, 'categories::kids');
        Widget::register(CategoriesImagesKids::class, 'categories::image-kids');
        Widget::register(CategoriesMainMenu::class, 'categories::main-menu');
        Widget::register(CategoriesMainMenuInner::class, 'categories::main-menu-children');
        Widget::register(CategoriesFooter::class, 'categories::footer-menu');
        Widget::register(CategoriesMobileMenu::class, 'categories::mobile-menu');
    }
    
    public function initSitemap()
    {
        $pages = CategoryModel::topLevel();
        
        $tree = $this->buildSitemapTree($pages);
        if (count($tree)) {
            $tree = [
                [
                    'name' => __('categories::site.catalog'),
                    'url' => route('site.categories'),
                    'items' => $tree,
                ]
            ];
        }
        
        return $tree;
    }
    
    protected function buildSitemapTree($pages)
    {
        $items = [];
        foreach ($pages as $page) {
            $item = [
                'name' => $page->current->name,
                'url' => route('site.category', ['slug' => $page->current->slug]),
            ];

            if (count($page->activeChildren)) {
                $item['items'] = $this->buildSitemapTree($page->activeChildren);
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
            $prefix = $language->default ? '' : '/'.$language->slug;
            $items[] = [
                'url' => url($prefix . route('site.categories', [], false), [], isSecure()),
            ];
            if($language->default){
                $default_language = $language->slug;
            }
        }
        CategoryTranslates::whereHas('row', function (Builder $builder){
            $builder->where('active', true);
        })->get()->each(function (CategoryTranslates $page) use (&$items, &$default_language) {
// ============================== Filters Sitemap ============================== //
            $this->categoryId = $page->id;
            $pf = new ProductFilter($page->id);
            $pf->setupFilters();

            foreach (ProductsFilter::getBlocks() as $block) {
                foreach ($block->getElements() as $element) {
                    if ($element->showInFilter()){
                        $filterUrl = $element->linkSitemap('site.category', array('slug' => $page->slug));
                        $items[] = array('url' => $filterUrl);
                    }
                }
            }
// ============================== Filters Sitemap ============================== //
            $prefix = ($default_language === $page->language) ? '' : '/' . $page->language;
            $items[] = [
                'url' => url($prefix . route('site.category', ['slug' => $page->slug], false), [], isSecure()),
            ];
        });

        return $items;
    }
    
}
