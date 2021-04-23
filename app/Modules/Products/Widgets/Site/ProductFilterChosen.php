<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Filter\FilterBlock;
use App\Components\Filter\FilterElement;
use App\Components\Widget\AbstractWidget;
use ProductsFilter, Catalog;
use Illuminate\Support\Collection;

/**
 * Class ProductFilterChosen
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductFilterChosen implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $chosen = new Collection();
        ProductsFilter::getBlocks()->each(function (FilterBlock $block) use ($chosen) {
            $block->getElements()->each(function (FilterElement $element) use ($chosen) {
                if ($element->selected) {
                    $chosen->push($element);
                }
            });
        });
        $price = $this->getChosenPrice();
        if ($chosen->isEmpty() && !$price) {
            return null;
        }
        return view('products::site.widgets.filter-param.param', [
            'elements' => $chosen,
            'price' => $price,
        ]);
    }
    
    private function getChosenPrice(): ?array
    {
        list ($minPrice, $maxPrice) = array_pad(explode('-', request()->query('price')), 2, null);
        if (!$minPrice && !$maxPrice) {
            return null;
        }
        if (!$minPrice) {
            if (Catalog::currenciesLoaded()) {
                $maxPrice = Catalog::currency()->formatWithoutCalculation($maxPrice);
            }
            $text = "до $maxPrice";
        } elseif(!$maxPrice) {
            if (Catalog::currenciesLoaded()) {
                $minPrice = Catalog::currency()->formatWithoutCalculation($minPrice);
            }
            $text = "от $minPrice";
        } else {
            if (Catalog::currenciesLoaded()) {
                $minPrice = Catalog::currency()->formatWithoutCalculation((float)$minPrice);
                $maxPrice = Catalog::currency()->formatWithoutCalculation((float)$maxPrice);
            }
            $text = "от $minPrice до $maxPrice";
        }
        $parameters = ProductsFilter::getParametersAsArray(ProductsFilter::getParameters());
        unset($parameters['price']);
        return [
            'name' => $text,
            'link' => ProductsFilter::generateUrl($parameters),
        ];
    }

}
