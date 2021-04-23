<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class CompareProductCard
 *
 * @package App\Modules\Products\Widgets\Site
 */
class CompareProductCard implements AbstractWidget
{
    
    /**
     * @var Product
     */
    protected $product;
    
    /**
     * CompareProductCard constructor.
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
        if (!$this->product) {
            return null;
        }
        return view('products::site.widgets.compare-item-list.compare-group-card', [
            'product' => $this->product,
        ]);
    }
    
}
