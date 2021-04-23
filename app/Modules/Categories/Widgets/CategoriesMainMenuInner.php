<?php

namespace App\Modules\Categories\Widgets;

use App\Components\Widget\AbstractWidget;

class CategoriesMainMenuInner implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('categories::site.widgets.left-sidebar.categories-left-inner');
    }
    
}
