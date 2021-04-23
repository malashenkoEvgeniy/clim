<?php

namespace App\Modules\Wishlist\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Wishlist;

/**
 * Class TotalAmount
 *
 * @package App\Modules\Wishlist\Widgets
 */
class TotalAmount implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!Wishlist::count()) {
            return null;
        }
        $amount = 0;
        $total = 0;
        Product::whereIn('id', Wishlist::getProductsIds())->get()->each(function (Product $product) use (&$amount, &$total) {
            if ($product->active) {
                $amount += $product->price_for_site;
                $total++;

            }
        });
        if (!$total) {
            return null;
        }
        return view('wishlist::site.widget-with-money', [
            'total' => $total,
            'amount' => \Catalog::currency()->format($amount),
        ]);
    }
    
}
