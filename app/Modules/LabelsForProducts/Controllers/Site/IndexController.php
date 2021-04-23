<?php

namespace App\Modules\LabelsForProducts\Controllers\Site;

use App\Core\SiteController;
use App\Modules\LabelsForProducts\Models\Label;
use App\Modules\Products\Models\ProductGroup;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class IndexController
 * @package App\Modules\LabelsForProducts\Controllers\Site
 */
class IndexController extends SiteController
{
    
    /**
     * Products list after search
     *
     * @param string $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(string $slug)
    {
        /** @var Label $label */
        $label = Label::getByCurrent('slug', $slug);

        abort_unless($label && $label->exists && $label->active, 404);
    
        $this->meta($label->current, $label->current->content);
        $this->breadcrumb($label->current->name, 'site.products-by-labels', [$label->current->slug]);
        $this->setOtherLanguagesLinks($label);
        $this->pageNumber();
        $this->canonical(route('site.products-by-labels',[$label->current->slug]));
        /** @var ProductGroup|Collection $groups */
        $groups = $label->groups()->paginate(config('db.labels.per-page', 10));
        if ($groups->isNotEmpty()) {
            return view('products::site.products-list-no-filter', [
                'groups' => $groups,
                'sortable' => false,
            ]);
        }
        return view('labels::site.no-products');
    }
    
}
