<?php

namespace App\Modules\Orders\Components\Cart;

use Illuminate\Support\Facades\Facade as BaseFacade;

class CartFacade extends BaseFacade
{
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Cart::class;
    }
}
