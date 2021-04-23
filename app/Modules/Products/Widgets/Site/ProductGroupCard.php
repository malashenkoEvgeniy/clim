<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\ProductGroup;

/**
 * Class ProductGroupCard
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductGroupCard implements AbstractWidget
{
    
    /**
     * @var ProductGroup
     */
    protected $item;
    
    /**
     * @var bool
     */
    protected $showDescription;
    
    /**
     * ProductCard constructor.
     *
     * @param ProductGroup $item
     * @param bool $showDescription
     */
    public function __construct(ProductGroup $item, bool $showDescription = true)
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
        return view('products::site.widgets.item-card.item-group-card', [
            'group' => $this->item,
            'product' => $this->item->relevant_product,
            'showDescription' => $this->showDescription,
        ]);
    }
    
}
