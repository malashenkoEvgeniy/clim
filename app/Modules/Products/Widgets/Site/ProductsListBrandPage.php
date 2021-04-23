<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProductsListBrandPage
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductsListBrandPage implements AbstractWidget
{
    
    /**
     * @var int
     */
    protected $brandId;
    
    /**
     * ProductsListBrandPage constructor.
     *
     * @param int $brandId
     */
    public function __construct(int $brandId)
    {
        $this->brandId = $brandId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $forFilter = request()->only('order');
        $forFilter['filter']['brand'][] = $this->brandId;
        $forFilter['order'] = $forFilter['order'] ?? 'default';

        $groups = ProductGroup::getFilteredList($forFilter, (int)request()->query('per-page'));
        if ($groups->isEmpty()) {
            return null;
        }
        return view('products::site.products-list-no-filter', [
            'groups' => $groups,
        ]);
    }
    
}
