<?php

namespace App\Modules\Products\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Catalog;

/**
 * Class ProductAmountOld
 *
 * @package App\Modules\Products\Widgets
 */
class ProductAmountOld implements AbstractWidget
{
    
    /**
     * @var array
     */
    protected $quantities;
    
    /**
     * ProductAmountOld constructor.
     *
     * @param array $quantities
     */
    public function __construct(array $quantities = [])
    {
        $this->quantities = $quantities;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $amount = 0;
        if (count($this->quantities) > 0) {
             Product::whereIn('id', array_keys($this->quantities))
                ->active(true)
                ->get()
                ->each(function (Product $product) use (&$amount) {
                    $amount += $product->price * (int)array_get($this->quantities, $product->id);
                });
        }
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->format($amount);
        }
        return $amount;
    }
    
}
