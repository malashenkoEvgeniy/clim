<?php

namespace App\Modules\Products\Widgets\Site;

use App\Components\Filter\FilterBlock;
use App\Components\Widget\AbstractWidget;
use App\Modules\Features\Models\Feature;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\ProductGroup;
use App\Modules\Products\Models\ProductGroupFeatureValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Brands\Provider as BrandProvider;
use App\Modules\Products\Models\ProductGroupFeatureValue as ProductFilterModel;
use DB, ProductsFilter;

/**
 * Class ProductFilter
 *
 * @package App\Modules\Products\Widgets\Site
 */
class ProductFilter implements AbstractWidget
{

    /**
     * @var Model|null
     */
    protected $categoryId;

    /**
     * ProductFilter constructor.
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
        BrandProvider::filter();
        $this->addFeaturesToFilter();
        ProductsFilter::generateIds();
        $this->checkMainFeatures();
        $this->addCounters();
        $this->addCountersFromFilteredProducts();
        
        $minPrice = Product::getMinPriceInCategory($this->categoryId);
        $maxPrice = Product::getMaxPriceInCategory($this->categoryId);
        if (\Catalog::currenciesLoaded()) {
            $minPrice = \Catalog::currency()->calculate($minPrice);
            $maxPrice = \Catalog::currency()->calculate($maxPrice);
        }

        return view('products::site.widgets.filter-accordion.accordion', [
            'minPrice' => floor($minPrice),
            'maxPrice' => ceil($maxPrice),
        ]);
    }

    public function setupFilters()
    {
        BrandProvider::filter();
        $this->addFeaturesToFilter();
        ProductsFilter::generateIds();
        $this->checkMainFeatures();
        $this->addCounters();
        $this->addCountersFromFilteredProducts();
    }
    
    private function addFeaturesToFilter(): void
    {
        ProductGroupFeatureValue::whereHas('group.otherCategories', function (Builder $builder) {
            $builder->where('category_id', $this->categoryId);
        })
            ->whereHas('feature', function (Builder $builder) {
                $builder
                    ->where('active', true)
                    ->where('in_filter', true);
            })
            ->whereHas('value', function (Builder $builder) {
                $builder->where('active', true);
            })
            ->with('value', 'value.current', 'feature', 'feature.current')
            ->get()
            ->sortBy('value.position')
            ->each(function (ProductGroupFeatureValue $featureValue) {
                $feature = $featureValue->feature;
                if (!$feature->active || !$feature->in_filter) {
                    return;
                }
                $block = ProductsFilter::getBlockById($feature->id) ?: ProductsFilter::addBlock(
                    $feature->current->name,
                    $feature->current->slug,
                    true
                )->setId($feature->id);
                if ($feature->type === Feature::TYPE_MULTIPLE) {
                    $block->setAsMultiple();
                }
                $value = $featureValue->value;
                $valueBlock = $block->getElementById($value->id);
                if (!$valueBlock && $value->active) {
                    $block->addElement(
                        $value->current->name,
                        $value->current->slug
                    )->setId($value->id);
                }
            });
    }
    
    private function checkMainFeatures(): void
    {
        ProductGroup::select(['feature_id'])
            ->active(true)
            ->whereHas('otherCategories', function (Builder $builder) {
                $builder->where('category_id', $this->categoryId);
            })
            ->groupBy('feature_id')
            ->get()
            ->each(function (ProductGroup $group) {
                $block = ProductsFilter::getBlockById($group->feature_id);
                if ($block) {
                    $block->setAsMain();
                }
            });
    }
    
    private function addCounters(): void
    {
        ProductFilterModel::select(['value_id', 'feature_id', DB::raw('COUNT(group_id) as count')])
            ->whereHas('group', function (Builder $builder) {
                return $builder->where('active', true);
            })
            ->whereHas('group.otherCategories', function (Builder $builder) {
                $builder->where('category_id', $this->categoryId);
            })
            ->groupBy('feature_id', 'value_id')
            ->get()
            ->each(function (ProductFilterModel $filter) {
                ProductsFilter::setCounters([
                    $filter->feature_id => [
                        $filter->value_id => $filter->count,
                    ],
                ]);
            });
        ProductGroup::select(['brand_id', DB::raw('COUNT(brand_id) as count')])
            ->where('active', true)
            ->whereHas('otherCategories', function (Builder $builder) {
                $builder->where('category_id', $this->categoryId);
            })
            ->groupBy('brand_id')
            ->get()
            ->each(function (ProductGroup $group) {
                ProductsFilter::setCounters([
                    'brand' => [
                        $group->brand_id => $group->count,
                    ],
                ]);
            });
    }
    
    private function addCountersFromFilteredProducts(): void
    {
        if (!config('db.products.filter-counters', true)) {
            return;
        }
        $forFilter = request()->only('price');
        $forFilter['filter'] = ProductsFilter::getFilterParametersIdsFromQuery()->toArray();
        if (!$forFilter['filter'] || !is_array($forFilter['filter']) || empty($forFilter['filter'])) {
            return;
        }
        ProductsFilter::getBlocks()->each(function (FilterBlock $block) use ($forFilter) {
            unset($forFilter['filter'][(int)$block->id], $forFilter['filter'][(string)$block->alias]);

            if ($block->alias === 'brand') {
                ProductGroup::select(['brand_id', DB::raw('COUNT(brand_id) as count')])
                    ->where('active', true)
                    ->whereHas('otherCategories', function (Builder $builder) {
                        $builder->where('category_id', $this->categoryId);
                    })
                    ->filter($forFilter)
                    ->groupBy('brand_id')
                    ->get()
                    ->each(function (ProductGroup $group) {
                        ProductsFilter::setFilteredCounters([
                            'brand' => [
                                $group->brand_id => $group->count,
                            ],
                        ]);
                    });
            } else {
                ProductFilterModel::select(['value_id', DB::raw('COUNT(DISTINCT group_id) as count')])
                    ->whereHas('group', function (Builder $builder) {
                        return $builder->where('active', true);
                    })
                    ->whereHas('group.otherCategories', function (Builder $builder) {
                        $builder->where('category_id', $this->categoryId);
                    })
                    ->where('feature_id', $block->id)
                    ->filter($forFilter)
                    ->groupBy('value_id')
                    ->get()
                    ->each(function (ProductFilterModel $filter) use ($block) {
                        ProductsFilter::setFilteredCounters([
                            $block->id => [
                                $filter->value_id => $filter->count,
                            ],
                        ]);
                    });
            }
        });
    }

}
