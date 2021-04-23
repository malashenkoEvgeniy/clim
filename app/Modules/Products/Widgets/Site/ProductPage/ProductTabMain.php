<?php

namespace App\Modules\Products\Widgets\Site\ProductPage;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductTabMain
 *
 * @package App\Modules\Products\Widgets\Site\ProductPage
 */
class ProductTabMain implements AbstractWidget
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
        if (!$this->product) {
            return null;
        }
        return view('products::site.widgets.product.product-facade.product-facade', [
            'product' => $this->product,
        ]);
    }

}
