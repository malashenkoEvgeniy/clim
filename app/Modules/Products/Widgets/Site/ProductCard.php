<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\Product;

/**
 * Class ProductCard
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductCard implements AbstractWidget
{

    /**
     * @var Product
     */
    protected $item;

    /**
     * @var bool
     */
    protected $showDescription;

    /**
     * ProductCard constructor.
     *
     * @param Product $item
     * @param bool $showDescription
     */
    public function __construct(Product $item, bool $showDescription = true)
    {
        $this->item = $item;
        $this->showDescription = $showDescription;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('products::site.widgets.item-card.item-card', [
            'group' => $this->item->group,
            'product' => $this->item,
            'showDescription' => $this->showDescription,
        ]);
    }

}
