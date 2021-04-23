<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Categories\Models\Category;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CompareProductsListAll
 *
 * @package App\Modules\Products\Widgets\Site
 */
class CompareProductsListAll implements AbstractWidget
{
    
    /**
     * @var array
     */
    protected $productsIds;
    
    /**
     * @var string
     */
    protected $routeName;
    
    /**
     * CompareProductsListAll constructor.
     *
     * @param array $productsIds
     * @param string $routeName
     */
    public function __construct(array $productsIds, string $routeName)
    {
        $this->productsIds = $productsIds;
        $this->routeName = $routeName;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (empty($this->productsIds)) {
            return null;
        }
        if (\Catalog::categoriesLoaded() === false) {
            return \Widget::show('products::compare-page', $this->productsIds);
        }
        $categories = Category::with('current')->where('active', true)->whereHas('products', function (Builder $builder) {
            $builder->whereIn('products.id', $this->productsIds);
        })->get();
        
        if ($categories->count() === 1) {
            $category = $categories->first();
            return \Widget::show(
                'products::compare-page',
                $this->productsIds,
                ['link' => $category->site_link, 'id' => $category->id]
            );
        }
        $products = Product::getMany($this->productsIds);
        $products->loadMissing('group');
        
        $productsInCategories = [];
        $products->each(function (Product $product) use (&$productsInCategories) {
            if ($product->group && $product->group->category_id) {
                $productsInCategories[$product->group->category_id] = array_merge(array_get($productsInCategories, $product->group->category_id, []), [$product]);
            }
        });

        return view('products::site.widgets.compare-item-list.item-list', [
            'products' => $productsInCategories,
            'categories' => $categories,
            'routeName' => $this->routeName,
        ]);
    }
    
}
