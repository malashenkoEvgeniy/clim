<?php

namespace App\Modules\Categories\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Categories\Models\Category;

class CategoriesFilter implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $categories = Category::getTreeFilter(request()->slug);
        if (!$categories || $categories->isEmpty()) {
            return null;
        }
        return view('categories::site.widgets.catalog-tree.tree', ['categories' => $categories]);
    }

}
