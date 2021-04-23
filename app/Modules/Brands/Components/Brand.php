<?php

namespace App\Modules\Brands\Components;

use App\Components\Catalog\Interfaces\BrandInterface;
use App\Components\Catalog\Interfaces\CatalogBaseInterface;
use App\Modules\Brands\Models\Brand as BrandModel;
use App\Modules\Brands\Rules\IsBrand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 *
 * @package App\Modules\Brands\Facades
 */
class Brand implements CatalogBaseInterface, BrandInterface
{
    
    public function all(?bool $active = null)
    {
        return $this->getQuery($active)->get();
    }
    
    public function paginate(int $limit, ?bool $active = null)
    {
        return $this->getQuery($active)->oldest('id')->paginate($limit);
    }
    
    public function oneBySlug(string $slug, ?bool $active = null)
    {
        return $this->getQuery($active)
            ->whereHas('current', function (Builder $query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->first();
    }
    
    public function one(int $brandId, ?bool $active = null)
    {
        return $this->getQuery($active)->whereId($brandId)->first();
    }
    
    public function many(array $brandsIds, ?bool $active = null)
    {
        return $this->getQuery($active)->whereIn('id', $brandsIds)->get();
    }
    
    public function getQuery(?bool $active = null)
    {
        $brands = BrandModel::with('current');
        if ($active !== null) {
            $brands->active($active);
        }
        return $brands;
    }
    
    public function rule()
    {
        return new IsBrand();
    }
    
    /**
     * @param Model|\App\Modules\Brands\Models\Brand $brand
     * @return string
     */
    public function linkInAdminPanel(Model $brand): ?string
    {
        return $brand->link_in_admin_panel;
    }
    
    public function getClassName(): string
    {
        return BrandModel::class;
    }
    
    public function getTableName(): string
    {
        $className = $this->getClassName();
        return (new $className)->getTable();
    }
    
}
