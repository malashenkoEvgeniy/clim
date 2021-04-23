<?php

namespace App\Modules\Wishlist\Widgets;

use App\Components\Widget\AbstractWidget;
use Wishlist;

/**
 * Class ActionBarButton
 *
 * @package App\Modules\Wishlist\Widgets
 */
class ActionBarButton implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('wishlist::site.action-bar-button', [
            'total' => Wishlist::count(),
        ]);
    }
    
}
