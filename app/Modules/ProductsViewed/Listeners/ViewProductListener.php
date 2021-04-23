<?php

namespace App\Modules\ProductsViewed\Listeners;

use App\Core\Interfaces\ListenerInterface;
use Cookie;

/**
 * Class ViewProductListener
 *
 * @package App\Modules\ProductsViewed\Listeners
 */
class ViewProductListener implements ListenerInterface
{
    
    public static function listens(): string
    {
        return 'products::view';
    }
    
    /**
     * Handle the event.
     *
     * @param int $productId
     * @return void
     */
    public function handle(int $productId)
    {
        $viewedProductsIds = request()->cookie('viewed_products', '[]');
        $viewedProductsIds = json_decode($viewedProductsIds, true) ?: [];
        if (!in_array($productId, $viewedProductsIds)) {
            array_unshift($viewedProductsIds, $productId);
        }
        $viewedProductsIds = array_slice($viewedProductsIds, 0, 20);
        Cookie::queue(Cookie::forever('viewed_products', json_encode(array_unique($viewedProductsIds))));
    }
}
