<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductPrice
 *
 * @package App\Modules\Products\Widgets
 */
class ProductPrice implements AbstractWidget
{
    
    /**
     * @var Product
     */
    protected $product;
    
    /**
     * ProductCard constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('products::site.widgets.product.item-card-price.item-card-price', [
            'old_value' => $this->product->formatted_old_price,
            'value' => $this->product->formatted_price,
        ]);
    }
    
}
