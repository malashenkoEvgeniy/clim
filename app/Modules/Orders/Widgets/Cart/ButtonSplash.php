<?php

namespace App\Modules\Orders\Widgets\Cart;

use App\Components\Widget\AbstractWidget;
use Cart;

/**
 * Class Labels
 *
 * @package App\Modules\LabelsForProducts\Widgets
 */
class ButtonSplash implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('orders::site.cart.splash', [
            'cart' => Cart::me(),
        ]);
    }
    
}
