<?php

namespace App\Modules\Categories\Widgets;

use App\Components\Widget\AbstractWidget;

/**
 * Class CategoriesMobileMenu
 *
 * @package App\Modules\Categories\Widgets
 */
class CategoriesMobileMenu implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('categories::site.widgets.mobile-list.index');
    }
    
}
