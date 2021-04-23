<?php

namespace App\Modules\Orders\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductWholesale;

/**
 * Class ProductsToCheckout
 *
 * @package App\Modules\Products\Listeners
 */
class ProductsToCheckout implements ListenerInterface
{
    
    public static function listens()
    {
        return 'products::items-for-checkout-ready';
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function handle(array $items)
    {
        foreach ($items as $product) {
            foreach ($product as $item) {
                if (!$item['price']) {
                    continue;
                }
                $price = ProductWholesale::whereProductId($item['product_id'])
                    ->where('quantity', '>=', $item['quantity'])
                    ->orderBy('quantity')
                    ->first();
                if ($price) {
                    $item['old_price'] = $item['price'];
                    $item['price'] = $price->price;
                }
                OrderItem::store($item);
            }
        }
    }
    
}
