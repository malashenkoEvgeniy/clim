<?php

namespace App\Modules\Orders\Widgets\Cart;

use App\Components\Widget\AbstractWidget;
use Cart;

/**
 * Class Labels
 *
 * @package App\Modules\LabelsForProducts\Widgets
 */
class MobileButton implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('orders::site.cart.mobile-button', [
            'cart' => Cart::me(),
        ]);
    }

}
