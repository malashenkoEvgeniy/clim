<?php

namespace App\Modules\Products\Filters;

use App\Modules\Products\Models\ProductGroup;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Catalog, Lang;

/**
 * Class SearchGroupsFilter
 *
 * @package App\Modules\Products\Filters
 */
class SearchGroupsFilter extends ModelFilter
{
    public function filter(array $filters)
    {
        foreach ($filters as $parameter => $values) {
            if ($parameter === 'brand') {
                $this->whereHas('group', function (Builder $builder) use ($parameter, $values) {
                    return $builder->whereIn('brand_id', (array)$values);
                });
            } else {
                $this->whereHas('same', function (Builder $builder) use ($parameter, $values) {
                    return $builder
                        ->where('feature_id', $parameter)
                        ->whereIn('value_id', (array)$values);
                });
            }
        }
        return $this;
    }
    
    public function price(string $price)
    {
        list ($priceMin, $priceMax) = array_pad(explode('-', $price), 2, null);
        $priceMin = (float)$priceMin;
        $priceMax = (float)$priceMax;
        if (Catalog::currenciesLoaded()) {
            $priceMin = Catalog::currency()->calculateBack($priceMin);
            $priceMax = Catalog::currency()->calculateBack($priceMax);
        }
        return $this->whereHas('product', function (Builder $query) use ($priceMin, $priceMax) {
            if ($priceMin) {
                $query->where('price', '>=', $priceMin);
            }
            if ($priceMax) {
                $query->where('price', '<=', $priceMax);
            }
        });
    }
    
}
