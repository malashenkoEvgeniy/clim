<?php

namespace App\Modules\Categories\Controllers\Site;

use App\Core\Modules\SystemPages\Models\SystemPage;
use App\Core\SiteController;
use App\Modules\Categories\Models\Category;
use EloquentFilter\Filterable;
use Catalog, Widget;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Spatie\PaginateRoute\PaginateRouteFacade;

/**
 * Class CategoryController
 *
 * @package App\Modules\Categories\Controllers\Site
 */
class CategoryController extends SiteController
{
    use Filterable;

    /**
     * @var SystemPage
     */
    static $categoriesMainPage;

    /**
     * CategoryController constructor.
     */
    public function __construct()
    {
        static::$categoriesMainPage = SystemPage::getByCurrent('slug', 'categories');
        abort_unless(static::$categoriesMainPage && static::$categoriesMainPage->exists, 404);
    }

    /**
     * Categories list page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->meta(static::$categoriesMainPage->current, static::$categoriesMainPage->current->content);
        $this->setOtherLanguagesLinks(static::$categoriesMainPage);
        Catalog::category()->addMainCategoriesPageBreadcrumb(static::$categoriesMainPage->current->name);
        $categories = Category::topLevel();
        $categories->load('activeChildren', 'activeChildren.current');
        $this->pageNumber();
        $this->canonical(route('site.categories'));
        return view('categories::site.categories', [
            'categories' => $categories,
            'page' => static::$categoriesMainPage,
        ]);
    }

    /**
     * Show inner page for category
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(string $slug)
    {
        /** @var Category $category */
        $category = Category::getOneBySlug($slug);
        abort_unless(
            $category &&
            $category->exists &&
            $category->active, 404);
        Catalog::category()->addMainCategoriesPageBreadcrumb(static::$categoriesMainPage->current->name);
        Catalog::category()->fillParentsBreadcrumbs($category);
        $this->meta($category->current, $category->current->seo_text);
        $this->metaTemplate(Category::SEO_TEMPLATE_ALIAS, [
            'name' => $category->current->name,
            'content' => $category->current->seo_text,
        ]);
        $this->setOtherLanguagesLinks($category);
        $this->pageNumber();
        if (request()->query()) {
            $this->hideDescriptionKeywords();
        }
        $this->canonical(route('site.category', [$category->current->slug]));
        if (config('db.products.show-categories-if-has', false)) {
            $category->loadMissing('activeChildren');
            if ($category->activeChildren->isNotEmpty()) {
                $category->loadMissing('activeChildren.current');
                return view('categories::site.categories', [
                    'categories' => $category->activeChildren,
                    'page' => $category,
                ]);
            }
        }
        $productsList = Widget::show('products::category-page', $category->id);
        return $productsList ?? view('categories::site.no-products', [
                'page' => $category,
            ]);
    }

}
