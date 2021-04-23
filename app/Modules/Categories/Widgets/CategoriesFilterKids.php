<?php

namespace App\Modules\Categories\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Categories\Models\Category;

/**
 * Class CategoriesFilterKids
 *
 * @package App\Modules\Categories\Widgets
 */
class CategoriesFilterKids implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $categories = Category::getKidsOrSameCategoriesIfEmpty(request()->slug);
        if (!$categories || $categories->isEmpty()) {
            return null;
        }
        return view('categories::site.widgets.kids-list.nav-links', [
            'categories' => $categories,
            'currentCategorySlug' => request()->slug,
        ]);
    }

}
