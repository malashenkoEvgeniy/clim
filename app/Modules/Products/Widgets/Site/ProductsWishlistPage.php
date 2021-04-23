<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductControls
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductsWishlistPage implements AbstractWidget
{
    
    /**
     * @var Product
     */
    protected $productsIds;
    
    /**
     * @var int
     */
    protected $limit;
    
    /**
     * ProductCard constructor.
     *
     * @param array $productsIds
     * @param int $limit
     */
    public function __construct(array $productsIds, int $limit = 10)
    {
        $this->productsIds = $productsIds;
        $this->limit = $limit;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $products = Product::whereIn('id', $this->productsIds)
            ->active(true)
            ->oldest('position')
            ->latest('id')
            ->paginate($this->limit ?: 10);
        if (!$products->total()) {
            return null;
        }
        return view('products::site.widgets.wishlist-page', [
            'total' => count($this->productsIds),
            'products' => $products,
        ]);
    }
    
}
