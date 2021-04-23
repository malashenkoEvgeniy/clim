<?php

namespace App\Modules\Categories\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Categories\Models\Category;
use Illuminate\Support\Collection;
use Html;

/**
 * Class CategoriesList
 *
 * @package App\Modules\Categories\Widgets
 */
class CategoriesList implements AbstractWidget
{
    
    /**
     * @var array
     */
    protected $categoriesIds;
    
    protected $noCategories = '&mdash;';
    
    /**
     * @var Collection|Category[]
     */
    private static $categories;
    
    /**
     * CategoriesList constructor.
     *
     * @param null|array $categoriesIds
     */
    public function __construct(?array $categoriesIds = null)
    {
        $this->categoriesIds = $categoriesIds ?? [];
        if (!static::$categories) {
            static::$categories = new Collection();
        }
    }
    
    /**
     * @return string
     */
    public function render()
    {
        if (!$this->categoriesIds) {
            return $this->noCategories;
        }
        $categoriesIds = $this->categoriesIds;
        $categories = [];
        foreach ($this->categoriesIds as $categoryId) {
            if (static::$categories->has($categoryId)) {
                $categories[] = $this->getLink(static::$categories->get($categoryId));
                $categoriesIds = array_diff($categoriesIds, [$categoryId]);
            }
        }
        if ($categoriesIds) {
            Category::whereIn('id', $categoriesIds)
                ->each(function (Category $category) use (&$categories) {
                    $categories[] = $this->getLink($category);
                    static::$categories->put($category->id, $category);
                });
        }
        return implode(', ', $categories) ?: $this->noCategories;
    }
    
    /**
     * @param Category $category
     * @return \Illuminate\Support\HtmlString
     */
    private function getLink(Category $category)
    {
        return Html::link($category->link_in_admin_panel, $category->current->name, [
            'target' => '_blank',
        ]);
    }
    
}
