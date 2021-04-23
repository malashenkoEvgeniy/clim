<?php

namespace App\Modules\LabelsForProducts\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\LabelsForProducts\Models\Label;
use App\Modules\Products\Models\ProductGroup;
use Illuminate\Database\Eloquent\Collection;
use Widget;

/**
 * Class Labels
 *
 * @package App\Modules\LabelsForProducts\Widgets
 */
class Labels implements AbstractWidget
{
    /**
     * @var Label[]|Collection
     */
    static $labels;
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (static::$labels === null) {
            static::$labels = Label::getList(true);
        }
        if (!static::$labels || static::$labels->isEmpty()) {
            return null;
        }
        do {
            /** @var Label $label */
            $label = static::$labels->shift();
            /** @var Collection|ProductGroup[] $groups */
            $groups = $label->getPaginatedGroups();
        } while ($groups->count() === 0 && static::$labels->count() > 0);
        if ($groups->count() < config('db.labels.minimum-in-widget', Label::DEFAULT_MINIMUM_PRODUCTS_IN_WIDGET)) {
            return null;
        }
        return Widget::show(
            'products::groups-slider',
            $groups,
            $label->current->name,
            route('site.products-by-labels', $label->current->slug)
        );
    }
    
}
