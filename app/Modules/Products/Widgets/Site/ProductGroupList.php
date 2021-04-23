<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\ProductGroup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class ProductsGroupList
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductGroupList implements AbstractWidget
{

    /**
     * @var ProductGroup[]|Collection|LengthAwarePaginator|null
     */
    protected $groups;

    /**
     * @var bool
     */
    protected $fullWidth;

    /**
     * ProductsList constructor.
     *
     * @param ProductGroup[]|Collection|LengthAwarePaginator|null $groups
     * @param bool $fullWidth
     */
    public function __construct($groups, bool $fullWidth = false)
    {
        $this->groups = $groups;
        $this->fullWidth = $fullWidth;
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
        ProductGroup::loadMissingForLists($this->groups);
        return view('products::site.widgets.item-list.item-group-list', [
            'groups' => $this->groups,
            'full_width' => $this->fullWidth,
        ]);
    }

}
