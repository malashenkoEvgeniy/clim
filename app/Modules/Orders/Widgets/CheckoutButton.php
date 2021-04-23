<?php

namespace App\Modules\Orders\Widgets;

use App\Components\Widget\AbstractWidget;
use Cart;

/**
 * Class CheckoutButton
 *
 * @package App\Modules\Orders\Widgets
 */
class CheckoutButton implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('orders::site.cart.checkout-button', [
            'cart' => Cart::me(),
            'canMakeOrder' => true,
            'link' => route('site.checkout'),
        ]);
    }
    
}
