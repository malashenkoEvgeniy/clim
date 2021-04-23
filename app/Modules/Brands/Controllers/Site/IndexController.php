<?php

namespace App\Modules\Brands\Controllers\Site;

use App\Core\SiteController;
use App\Modules\Brands\Models\Brand;
use Widget;

/**
 * Class IndexController
 *
 * @package App\Modules\Brands\Controllers\Admin
 */
class IndexController extends SiteController
{
    
    public function show(string $slug)
    {
        /** @var Brand $brand */
        $brand = Brand::getByCurrent('slug', $slug);
        abort_unless($brand && $brand->exists && $brand->active, 404);
        $this->breadcrumb($brand->current->name, 'site.brands.show', [$brand->current->slug]);
        $this->meta($brand->current, $brand->current->content);
        $this->pageNumber();
        $this->canonical(route('site.brands.show', [$brand->current->slug]));
        $productsList = Widget::show('products::brand-page', $brand->id);
        return $productsList ?? view('brands::site.no-products', [
            'page' => $brand,
        ]);
    }
    
}
