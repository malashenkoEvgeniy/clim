<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProductsSlider
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductsSlider implements AbstractWidget
{

    /**
     * @var Product[]|Collection
     */
    protected $products;
    
    /**
     * @var string
     */
    protected $text;
    
    /**
     * @var string
     */
    protected $link;

    /**
     * ProductsList constructor.
     *
     * @param Product[]|Collection $products
     * @param string $text
     * @param string $link
     */
    public function __construct(Collection $products, string $text, ?string $link = null)
    {
        $this->products = $products;
        $this->text = $text;
        $this->link = $link;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->products || $this->products->isEmpty()) {
            return null;
        }
        if ($this->products->count() > Product::LIMIT_SLIDER_WIDGET) {
            $this->products = $this->products->take(Product::LIMIT_SLIDER_WIDGET);
        }
        Product::loadMissingForLists($this->products);
        return view('products::site.widgets.item-list.item-slider-min', [
            'products' => $this->products,
            'text' => $this->text,
            'link' => $this->link,
        ]);
    }

}
