<?php

namespace App\Modules\Categories\Components;

use App\Components\Catalog\Interfaces\CatalogBaseInterface;
use App\Components\Catalog\Interfaces\CategoryInterface;
use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\Categories\Models\Category as CategoryModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Seo;

/**
 * Class Category
 *
 * @package App\Modules\Categories\Facades
 * @method static getFacadeRoot()
 */
class Category implements CatalogBaseInterface, CategoryInterface
{
    
    public function all(?bool $active = null)
    {
        if ($active) {
            return CategoryModel::$dump;
        }
        return $this->getQuery($active)->oldest('position')->get();
    }
    
    public function paginate(int $limit, ?bool $active = null)
    {
        return $this->getQuery($active)->oldest('position')->paginate($limit);
    }
    
    public function oneBySlug(string $slug, ?bool $active = null)
    {
        if ($active) {
            return CategoryModel::getOneBySlug($slug);
        }
        return $this->getQuery($active)
            ->whereHas('current', function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->first();
    }
    
    public function one(int $categoryId, ?bool $active = null)
    {
        if ($active) {
            return CategoryModel::getOne($categoryId);
        }
        return $this->getQuery($active)->whereId($categoryId)->first();
    }
    
    public function many(array $categoriesIds, ?bool $active = null)
    {
        return $this->getQuery($active)->whereIn('id', $categoriesIds)->get();
    }
    
    public function getQuery(?bool $active = null)
    {
        $categories = CategoryModel::with('current');
        if ($active !== null) {
            $categories->active($active);
        }
        return $categories;
    }
    
    public function getClassName(): string
    {
        return CategoryModel::class;
    }
    
    public function getTableName(): string
    {
        $className = $this->getClassName();
        return (new $className)->getTable();
    }
    
    /**
     * Breadcrumbs for categories
     *
     * @param CategoryModel|Model|null $category
     */
    public function fillParentsBreadcrumbs(?Model $category = null): void
    {
        if (!$category) {
            return;
        }
        if (is_int($category)) {
            $category = CategoryModel::getOne($category);
            if (!$category) {
                return;
            }
        }
        $categories = new Collection();
        $categories->push($category);
        while ((int)$category->parent_id > 0) {
            $category = $category->getParent();
            $categories->push($category);
        }
        foreach ($categories->reverse() as $category) {
            if ($category->active) {
                Seo::breadcrumbs()->add(
                    $category->current->name,
                    RouteObjectValue::make('site.category', [$category->current->slug])
                );
            }
        }
    }
    
    public function addMainCategoriesPageBreadcrumb(?string $title = null): void
    {
        if (!$title) {
            /** @var \App\Modules\Categories\Models\Category $category */
            $category = SystemPage::getByCurrent('slug', 'categories');
            $title = $category->current->name;
        }
        Seo::breadcrumbs()->add($title ?? 'categories::site.catalog', RouteObjectValue::make('site.categories'));
    }
    
}
