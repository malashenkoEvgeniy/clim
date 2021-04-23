<?php

namespace App\Modules\Products\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Modules\Products\Models\Product;

/**
 * Class ProductDataForCheckout
 *
 * @package App\Modules\Products\Listeners
 */
class ProductDataForCheckout implements ListenerInterface
{

    public static function listens()
    {
        return 'orders::data-for-checkout-ready-without-prices';
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     * @param array $items
     */
    public function handle(array $items)
    {
        Product::whereIn('id', array_keys($items))
            ->get()
            ->each(function (Product $product) use (&$items) {
                foreach ($items[$product->id] as $index => $item) {
                    $items[$product->id][$index]['price'] = $product->price;
                }
            });
        event('products::items-for-checkout-ready', [$items]);
    }

}
