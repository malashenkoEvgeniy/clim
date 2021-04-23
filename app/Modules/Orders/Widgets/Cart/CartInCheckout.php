<?php

namespace App\Modules\Orders\Widgets\Cart;

use App\Components\Widget\AbstractWidget;
use Cart;

/**
 * Class CartInCheckout
 *
 * @package App\Modules\Orders\Widgets
 */
class CartInCheckout implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('orders::site.cart.cart--checkout', [
            'cart' => Cart::me(),
        ]);
    }
    
}
