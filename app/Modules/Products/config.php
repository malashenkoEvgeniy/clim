<?php

use App\Modules\Products\Models\Product;

return [
    'availability' => [
        Product::NOT_AVAILABLE => 'products::general.not-available',
        Product::AVAILABLE => 'products::general.available',
    ],
    
    'available-order-fields' => [
        '' => 'products::site.order.default',
        'price-asc' => 'products::site.order.price-asc',
        'price-desc' => 'products::site.order.price-desc',
        'name-asc' => 'products::site.order.name-asc',
        'name-desc' => 'products::site.order.name-desc',
    ],
];
