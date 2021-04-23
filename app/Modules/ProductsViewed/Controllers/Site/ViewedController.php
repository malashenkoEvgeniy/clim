<?php

namespace App\Modules\ProductsViewed\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use Widget;

/**
 * Class ViewedController
 *
 * @package App\Modules\ProductsViewed\Controllers\Site
 */
class ViewedController extends SiteController
{
    
    /**
     * Products list after search
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var SystemPage $page */
        $page = SystemPage::getByCurrent('slug', 'viewed-products');
    
        $this->meta($page->current, $page->current->content);
        $this->breadcrumb($page->current->name, 'site.viewed-products');
        $this->setOtherLanguagesLinks($page);
        $this->pageNumber();
        $this->canonical(route('site.viewed-products'));
        $productsIds = request()->cookie('viewed_products', '[]');
        $productsIds = json_decode($productsIds, true);
        $productsIds = is_array($productsIds) ? $productsIds : [];
        
        $productsList = Widget::show('products::viewed-page', $productsIds ?: [], config('db.viewed.per-page', 10));
        return $productsList ?? view('viewed::site.no-viewed-products', [
            'page' => $page,
        ]);
    }
    
}
