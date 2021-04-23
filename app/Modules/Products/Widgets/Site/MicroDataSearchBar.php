<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;

/**
 * Class MicroDataSearchBar
 *
 * @package App\Modules\Products\Widgets\Site
 */
class MicroDataSearchBar implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (!config('db.microdata.search', true)) {
            return null;
        }
        return view('products::site.widgets.search-microdata');
    }

}
