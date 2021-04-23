<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductControls
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductControls implements AbstractWidget
{
    
    /**
     * @var Product
     */
    protected $product;
    
    /**
     * @var bool
     */
    protected $innerPage;
    
    /**
     * ProductCard constructor.
     *
     * @param Product $product
     * @param bool $innerPage
     */
    public function __construct(Product $product, bool $innerPage = false)
    {
        $this->product = $product;
        $this->innerPage = $innerPage;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $template = 'products::site.widgets.item-card.item-card-controls.item-card-controls';
        if ($this->innerPage) {
            $template = 'products::site.widgets.product.item-card-controls.item-card-controls';
        }
        return view($template, [
            'product' => $this->product,
        ]);
    }
    
}
