<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ProductsList
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductsList implements AbstractWidget
{

    /**
     * @var Product[]|Collection|LengthAwarePaginator|null
     */
    protected $products;

    /**
     * @var bool
     */
    protected $fullWidth;

    /**
     * ProductsList constructor.
     *
     * @param Product[]|Collection|LengthAwarePaginator|null $products
     * @param bool $fullWidth
     */
    public function __construct($products, bool $fullWidth = false)
    {
        $this->products = $products;
        $this->fullWidth = $fullWidth;
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
        return view('products::site.widgets.item-list.item-list', [
            'products' => $this->products,
            'full_width' => $this->fullWidth,
        ]);
    }

}
