<?php

namespace App\Modules\FastOrders\Widgets;

use App\Components\Widget\AbstractWidget;

class FastOrderClick implements AbstractWidget
{
    
    private $productId;
    
    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }
    
    public function render()
    {
        return view('fast_orders::site.click', [
            'url' => route('fast-orders-popup', $this->productId),
        ]);
    }
    
}
