<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;

/**
 * Class SearchBar
 *
 * @package App\Modules\Products\Widgets\Site
 */
class SearchBar implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('products::site.widgets.search-bar', [
            'query' => request()->query('query'),
            'orderBy' => request()->query('order'),
            'perPage' => request()->query('per-page'),
        ]);
    }
    
}
