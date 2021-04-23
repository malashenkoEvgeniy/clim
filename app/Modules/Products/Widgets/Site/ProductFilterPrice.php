<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;

/**
 * Class ProductFilterPrice
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductFilterPrice implements AbstractWidget
{
    
    protected $minPrice;
    
    protected $maxPrice;
    
    /**
     * ProductFilterPrice constructor.
     *
     * @param int $minPrice
     * @param int $maxPrice
     */
    public function __construct(int $minPrice, int $maxPrice)
    {
        $this->minPrice = $minPrice < $maxPrice ? $minPrice : $maxPrice;
        $this->maxPrice = $maxPrice > $minPrice ? $maxPrice : $minPrice;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->maxPrice || $this->minPrice == $this->maxPrice) {
            return null;
        }
        list ($filterMinPrice, $filterMaxPrice) = array_pad(explode('-', request()->query('price')), 2, null);
        return view('products::site.widgets.filter-price-range.price-range', [
            'priceMin' => $filterMinPrice ? floor($filterMinPrice) : $this->minPrice,
            'priceMax' => $filterMaxPrice ? ceil($filterMaxPrice) : $this->maxPrice,
            'min' => $this->minPrice,
            'max' => $this->maxPrice,
        ]);
    }
    
}
