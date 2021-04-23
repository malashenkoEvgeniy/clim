<?php

namespace App\Modules\CompareProducts\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use Catalog, CompareProducts, Widget;

/**
 * Class IndexController
 *
 * @package App\Modules\CompareProducts\Controllers\Site
 */
class IndexController extends SiteController
{

    /**
     * Show page with products for compare
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var SystemPage $page */
        $page = SystemPage::getByCurrent('slug', 'compare');
        abort_unless($page && $page->exists, 404);
        $this->breadcrumb($page->current->name, 'site.compare');
        $this->meta($page->current, $page->current->content);
        $this->pageNumber();
        $this->canonical(route('site.compare'));
        $products = Widget::show(
            'products::compare-page-all',
            CompareProducts::getProducts()->toArray(),
            'site.compare.category'
        );
        return view('compare::site.index-all', [
            'products' => $products,
        ]);
    }

    public function show(string $slug)
    {
        abort_unless(Catalog::categoriesLoaded(), 404);
        $category = Catalog::category()->oneBySlug($slug,true);
        abort_unless($category, 404);
        /** @var SystemPage $page */
        $page = SystemPage::getByCurrent('slug', 'compare');
        abort_unless($page && $page->exists, 404);
        $this->breadcrumb($page->current->name, 'site.compare');
        $this->breadcrumb($category->current->name, 'site.compare.category');
        $this->meta($page->current, $page->current->content);
        $this->pageNumber();
        $this->canonical(route('site.compare.category',[$category->current->slug]));
        $products = Widget::show(
            'products::compare-page',
            CompareProducts::getProducts()->toArray(),
            ['link' => $category->site_link, 'id' => $category->id]
        );
        
        return view('compare::site.index', [
            'products' => $products,
        ]);
    }

}
