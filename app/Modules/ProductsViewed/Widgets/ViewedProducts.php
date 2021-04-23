<?php

namespace App\Modules\ProductsViewed\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Widget, Cookie;

/**
 * Class ViewedProducts
 *
 * @package App\Modules\ProductsViewed\Widgets
 */
class ViewedProducts implements AbstractWidget
{
    const LIMIT_IN_WIDGET = 15;
    
    protected $ignoredProductId;
    
    public function __construct(?int $ignoredProductId = null)
    {
        $this->ignoredProductId = $ignoredProductId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $productsIds = request()->cookie('viewed_products', '[]');
        $productsIds = json_decode($productsIds, true);
        $productsIds = is_array($productsIds) ? $productsIds : [];
    
        $productsIds = array_slice($productsIds, 0, 20);
        $productsSort = array_flip($productsIds);
        
        $products = Product::getByIdsListWithIgnoredOne($productsIds, $this->ignoredProductId, 20)
            ->sort(function (Product $prev, Product $next) use ($productsSort) {
                return $productsSort[$prev->id] <=> $productsSort[$next->id];
            });
        
        return Widget::show(
            'products::slider',
            $products,
            trans('viewed::general.widget-name'),
            route('site.viewed-products')
        );
    }
    
}
