<?php

namespace App\Modules\Products\Widgets\Site\ProductPage;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Widget;

/**
 * Class ProductTabReviews
 *
 * @package App\Modules\Products\Widgets\Site\ProductPage
 */
class ProductTabReviews implements AbstractWidget
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
        if (!$this->product || !$this->product->group || !$this->product->group->relationExists('comments')) {
            return null;
        }
        $comments = Widget::show('comments::product-reviews', 'groups', $this->product->group->id);
        return view('products::site.widgets.product.product-reviews.product-reviews', [
            'product' => $this->product,
            'comments' => $comments,
        ]);
    }

}
