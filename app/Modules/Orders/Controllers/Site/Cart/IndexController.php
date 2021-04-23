<?php

namespace App\Modules\Orders\Controllers\Site\Cart;

use App\Core\SiteController;
use Cart;

/**
 * Class IndexController
 *
 * @package App\Modules\Orders\Controllers\Site
 */
class IndexController extends SiteController
{
    
    /**
     * Cart items list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->breadcrumb('orders::site.cart', 'site.cart.index');
        $this->sameMeta('orders::site.cart');
        return view('orders::site.cart.index', [
            'cart' => Cart::me(),
        ]);
    }
    
}