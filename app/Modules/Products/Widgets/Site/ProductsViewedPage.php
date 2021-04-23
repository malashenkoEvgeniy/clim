<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductsViewedPage
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductsViewedPage implements AbstractWidget
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
        if (!$this->productsIds) {
            return null;
        }
        $forFilter = request()->only('order');
        $forFilter['order'] = $forFilter['order'] ?? 'default';
        $productsQuery = Product::active(true)->filter($forFilter);
        $productsQuery->whereIn((new Product)->getTable() . '.id', $this->productsIds);
        $limit = (int)request()->query('per-page');
        $products = $productsQuery->paginate($limit ?: $this->limit);
        if ($products->isEmpty()) {
            return null;
        }
        Product::loadMissingForLists($products);
        return view('products::site.simple-products-list', [
            'products' => $products,
        ]);
    }
    
}
