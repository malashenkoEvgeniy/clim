<?php

namespace App\Modules\Brands\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Brands\Models\Brand;

class OurBrands implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!(bool)config('db.brands.show-our-brands-widget', true)) {
            return null;
        }
        $brands = Brand::allActive();
        if (!$brands || !$brands->count()) {
            return null;
        }
        return view('brands::site.our-brands', [
            'brands' => $brands,
        ]);
    }
    
}
