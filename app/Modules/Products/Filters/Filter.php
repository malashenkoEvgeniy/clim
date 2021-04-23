<?php

namespace App\Modules\Products\Filters;

use App\Modules\Products\Models\ProductGroup;
use EloquentFilter\ModelFilter;
use Illuminate\Database\Eloquent\Builder;
use Catalog, Lang;

/**
 * Class Filter
 *
 * @package App\Modules\Products\Filters
 */
class Filter extends ModelFilter
{
    public function filter(array $filters)
    {
        foreach ($filters as $parameter => $values) {
            if ($parameter === 'brand') {
                $this->whereIn('brand_id', $values);
            } else {
                $this->whereHas('same', function (Builder $builder) use ($parameter, $values) {
                    return $builder
                        ->where('feature_id', $parameter)
                        ->whereIn('value_id', $values);
                });
            }
        }
        return $this;
    }
    
    public function category(int $categoryId)
    {
        return $this->whereHas('otherCategories', function (Builder $builder) use ($categoryId) {
            $builder->where('category_id', $categoryId);
        });
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
        return $this->whereHas('products', function (Builder $query) use ($priceMin, $priceMax) {
            if ($priceMin) {
                $query->where('price', '>=', $priceMin);
            }
            if ($priceMax) {
                $query->where('price', '<=', $priceMax);
            }
        });
    }
    
    public function order(string $order)
    {
        $table = (new ProductGroup())->getTable();
        $tableToJoin = ProductGroup::getRelatedTableName();
        $this->latest("$table.available");
        switch ($order) {
            case 'price-asc':
                $this->oldest('price_min');
                break;
            case 'price-desc':
                $this->latest('price_max');
                break;
            case 'name-asc':
                $this
                    ->select("$table.*", "$tableToJoin.name")
                    ->join($tableToJoin, "$table.id", '=', "$tableToJoin.row_id")
                    ->where("$tableToJoin.language", Lang::getLocale())
                    ->oldest("$tableToJoin.name");
                break;
            case 'name-desc':
                $this
                    ->select("$table.*", "$tableToJoin.name")
                    ->join($tableToJoin, "$table.id", '=', "$tableToJoin.row_id")
                    ->where("$tableToJoin.language", Lang::getLocale())
                    ->latest("$tableToJoin.name");
                break;
            default:
                $this->oldest("$table.position");
                $this->latest("$table.id");
        }
        return $this;
    }
    
}
