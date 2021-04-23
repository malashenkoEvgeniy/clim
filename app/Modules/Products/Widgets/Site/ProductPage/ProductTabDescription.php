<?php

namespace App\Modules\Products\Widgets\Site\ProductPage;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductTabDescription
 *
 * @package App\Modules\Products\Widgets\Site\ProductPage
 */
class ProductTabDescription implements AbstractWidget
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
        if (!$this->product || !$this->product->current || !$this->product->group || !$this->product->group->current) {
            return null;
        }
        $strippedText = strip_tags($this->product->group->current->text, '<img>|<a>|<br>|<hr>');
        $trimmedText = trim($strippedText);
        if (!$trimmedText) {
            return null;
        }
        return view('products::site.widgets.product.product-desc.product-desc', [
            'text' => $this->product->group->current->text,
        ]);
    }

}
