<?php

namespace App\Modules\Products\Listeners;

use App\Core\Interfaces\ListenerInterface;
use App\Modules\Products\Models\ProductWholesale;

/**
 * Class SyncCategories
 *
 * @package App\Modules\Categories\Listeners
 */
class SyncWithWholesale implements ListenerInterface
{

    /**
     * @return string
     */
    public static function listens(): string
    {
        return 'products::saved';
    }

    /**
     * @param int $productId
     * @throws \Exception
     */
    public function handle(int $productId)
    {
        $quantities = (array)request()->input('wholesaleQuantities', []);
        $prices = (array)request()->input('wholesalePrices', []);
        ProductWholesale::whereProductId($productId)->delete();
        if (array_get($quantities, 0)) {
            foreach ($quantities as $key => $value) {
                if (array_get($quantities, $key) && array_get($prices, $key)) {
                    ProductWholesale::whereProductId($productId)
                        ->firstOrCreate([
                            'product_id' => $productId,
                            'quantity' => array_get($quantities, $key),
                            'price' => array_get($prices, $key),
                        ]);
                }
            }
        }
    }

}