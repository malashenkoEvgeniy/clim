<?php

namespace App\Modules\ProductsAvailability\Widgets;

use App\Components\Widget\AbstractWidget;

class ProductsAvailabilityClick implements AbstractWidget
{

    private $productId;

    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    public function render()
    {
        return view('products_availability::site.click', [
            'url' => route('products-availability-popup', $this->productId)
        ]);
    }

}
