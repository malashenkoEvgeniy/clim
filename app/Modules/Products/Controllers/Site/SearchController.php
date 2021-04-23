<?php

namespace App\Modules\Products\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class SearchController
 *
 * @package App\Modules\Products\Controllers\Site
 */
class SearchController extends SiteController
{
    
    /**
     * Products list after search
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /** @var SystemPage $page */
        $page = SystemPage::getByCurrent('slug', 'search');
        $this->setOtherLanguagesLinks($page);
        $this->meta($page->current, $page->current->content);
        $this->breadcrumb($page->current->name, 'site.search-products');
        $this->canonical(route('site.search-products'));
        $products = new Collection();
        $query = request()->query('query');
        if ($query) {
            $products = Product::search();
        }
        return view('products::site.search', [
            'products' => $products,
            'query' => $query,
            'page' => $page,
            'total' => $products instanceof LengthAwarePaginator ? $products->total() : $products->count(),
        ]);
    }
    
}
