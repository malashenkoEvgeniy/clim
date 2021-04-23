<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\ProductGroup;
use Catalog;

/**
 * Class ProductGroupDescription
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductGroupDescription implements AbstractWidget
{
    
    /**
     * @var ProductGroup
     */
    protected $group;
    
    /**
     * ProductDescription constructor.
     *
     * @param ProductGroup $group
     */
    public function __construct(ProductGroup $group)
    {
        $this->group = $group;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (Catalog::featuresLoaded() === false) {
            return null;
        }
        if (!config('db.products.show-main-features')) {
            return null;
        }
        if (!$this->group->main_features) {
            return null;
        }
        return view('products::site.widgets.item-card.item-card-desc.item-card-desc', [
            'features' => $this->group->main_features,
        ]);
    }
    
}
