<?php

namespace App\Modules\Products\Controllers\Site;

use App\Core\SiteController;
use App\Modules\Categories\Models\Category;
use App\Modules\Products\Models\Product;
use Catalog;

/**
 * Class CategoryController
 *
 * @package App\Modules\Categories\Controllers\Admin
 */
class ProductsController extends SiteController
{
    
    /**
     * Show product page
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $slug)
    {
        /** @var Product $product */
        $product = Product::getByCurrent('slug', $slug);
        abort_unless($product && $product->exists, 404);
    
        $product->loadMissing(
            'group', 'group.current',
            'brand', 'brand.current',
            'group.featureValues', 'group.featureValues',
            'group.feature', 'group.feature.current',
            'value', 'value.current'
        );
        $this->meta($product->current, $product->current->seo_text);

        $categoriesNames = [];
        $product->group->otherCategories->each(function (Category $category) use (&$categoriesNames) {
            $categoriesNames[] = $category->current->name;
        });
        Catalog::category()->addMainCategoriesPageBreadcrumb();
        $category = Category::getOne($product->group->category_id);
        if ($category) {
            Catalog::category()->fillParentsBreadcrumbs($category);
        }
        
        $this->metaTemplate(Product::SEO_TEMPLATE_ALIAS, [
            'name' => $product->name,
            'category' => $category ? $category->current->name : '',
            'categories' => str_replace('&mdash;', '', implode(', ', $categoriesNames)),
            'price' => $product->formatted_price,
        ]);
        $this->breadcrumb($product->name, 'site.product', [$product->current->slug]);
        $this->setOtherLanguagesLinks($product);
        $this->canonical(route('site.product', [$product->current->slug]));
        event('products::view', $product->id);
        return view('products::site.index', [
            'product' => $product,
            'related' => $product->related,
            'tabs' => $product->tabs,
        ]);
    }
    
}
