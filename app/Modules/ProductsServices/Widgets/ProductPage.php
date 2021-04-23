<?php

namespace App\Modules\ProductsServices\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\ProductsServices\Models\ProductService;

/**
 * Class ProductPage
 *
 * @package App\Modules\ProductsServices\Widgets
 */
class ProductPage implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $services = ProductService::getList()->where('active', true);
        if ($services->isEmpty()) {
            return null;
        }
        return view('products_services::site.widget', [
            'services' => $services,
        ]);
    }
    
}
