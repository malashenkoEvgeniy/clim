<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\ProductGroup;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProductGroupSlider
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductGroupSlider implements AbstractWidget
{

    /**
     * @var ProductGroup[]|Collection
     */
    protected $groups;
    
    /**
     * @var string
     */
    protected $text;
    
    /**
     * @var string
     */
    protected $link;

    /**
     * ProductsList constructor.
     *
     * @param ProductGroup[]|Collection $groups
     * @param string $text
     * @param string $link
     */
    public function __construct(Collection $groups, string $text, ?string $link = null)
    {
        $this->groups = $groups;
        $this->text = $text;
        $this->link = $link;
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!$this->groups || $this->groups->isEmpty()) {
            return null;
        }
        if ($this->groups->count() > ProductGroup::LIMIT_SLIDER_WIDGET) {
            $this->groups = $this->groups->take(ProductGroup::LIMIT_SLIDER_WIDGET);
        }
        ProductGroup::loadMissingForLists($this->groups);
        return view('products::site.widgets.item-list.item-groups-slider-min', [
            'groups' => $this->groups,
            'text' => $this->text,
            'link' => $this->link,
        ]);
    }

}
