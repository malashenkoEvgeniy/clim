<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Catalog;

/**
 * Class ProductDescription
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductDescription implements AbstractWidget
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
     * ProductDescription constructor.
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
        if (Catalog::featuresLoaded() === false) {
            return null;
        }
        if (!config('db.products.show-features-productpage') && $this->innerPage === false) {
            return null;
        }
        if (!$this->product->main_features) {
            return null;
        }
        if ($this->innerPage) {
            return $this->product->main_features ?: null;
        }
        return view('products::site.widgets.item-card.item-card-desc.item-card-desc', [
            'features' => $this->product->main_features,
        ]);
    }
    
}
