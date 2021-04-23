<?php

namespace App\Modules\Wishlist\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use Wishlist, Widget;

/**
 * Class IndexController
 *
 * @package App\Modules\Wishlist\Controllers\Site
 */
class IndexController extends SiteController
{

    public function index()
    {
        /** @var SystemPage $page */
        $page = SystemPage::getByCurrent('slug', 'wishlist');
        abort_unless($page && $page->exists, 404);
        $this->meta($page->current, $page->current->content);
        $this->breadcrumb($page->current->name, 'site.wishlist');
        $this->pageNumber();
        $this->canonical(route('site.wishlist'));
        return view('wishlist::site.index', [
            'products' => Widget::show(
                'products::wishlist-page',
                Wishlist::getProductsIds(),
                config('db.wishlist.per-page', 10)
            ),
            'page' => $page,
        ]);
    }

}
