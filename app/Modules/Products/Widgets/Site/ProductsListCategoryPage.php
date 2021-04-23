<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Categories\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\UrlWindow;
use ProductsFilter, Widget;

/**
 * Class ProductsListCategoryPage
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductsListCategoryPage implements AbstractWidget
{
    
    /**
     * @var int
     */
    protected $categoryId;
    
    /**
     * ProductsList constructor.
     *
     * @param int $categoryId
     */
    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $filter = Widget::show('products::filter', $this->categoryId);
        
        $forFilter = request()->only('price', 'order');
        $forFilter['category'] = $this->categoryId;
        $forFilter['filter'] = ProductsFilter::getFilterParametersIdsFromQuery()->toArray();
        $forFilter['order'] = $forFilter['order'] ?? 'default';
        
        $groups = ProductGroup::getFilteredList($forFilter, (int)request()->query('per-page'));

        // --- [dg][dEF] redirect from overlimited pagination --- //        
        $curr_uri = $_SERVER['REQUEST_URI'];
        $curr_host = $_SERVER['HTTP_HOST'];
        if ($groups->currentPage() > $groups->lastPage() && $groups->currentPage() > 1){
            $new_uri = implode('/', array(Category::getOne($this->categoryId)->getSiteLinkAttribute(), $groups->getPageName(), $groups->lastPage()));
            header('Location: ' . $new_uri, true, 301);
            die();
        }

        if ($groups->isEmpty()) {
            return null;
        }

        return view('products::site.products-list', [
            'groups' => $groups,
            'categoryId' => $this->categoryId,
            'filter' => $filter,
        ]);
    }
    
}
