<?php

namespace App\Modules\Wishlist\Widgets;

use App\Components\Widget\AbstractWidget;
use Catalog, Wishlist;

/**
 * Class ActionBarButton
 * @package App\Modules\Wishlist\Widgets
 */
class WishlistMobileButton implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('wishlist::site.mobile-button', [
            'total' => Wishlist::count(),
        ]);
    }

}
