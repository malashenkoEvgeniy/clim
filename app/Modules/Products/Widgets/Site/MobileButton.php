<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;

/**
 * Class SearchBar
 *
 * @package App\Modules\Products\Widgets
 */
class MobileButton implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('products::site.widgets.mobile-button');
    }

}
