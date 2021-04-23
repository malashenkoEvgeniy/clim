<?php

namespace App\Modules\Products\Models;

use App\Modules\Features\Models\Feature;
use App\Modules\Features\Models\FeatureValue;
use App\Modules\Products\Filters\SearchGroupsFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Products\Models\ProductGroupFeatureValue
 *
 * @property int $id
 * @property int $group_id
 * @property int $product_id
 * @property int $feature_id
 * @property int $value_id
 * @property-read \App\Modules\Features\Models\Feature $feature
 * @property-read \App\Modules\Products\Models\ProductGroup $group
 * @property-read \App\Modules\Products\Models\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Products\Models\ProductGroupFeatureValue[] $same
 * @property-read \App\Modules\Features\Models\FeatureValue $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue whereFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupFeatureValue whereValueId($value)
 * @mixin \Eloquent
 */
class ProductGroupFeatureValue extends Model
{
    use Filterable;
    
    protected $table = 'products_groups_features_values';
    
    protected $fillable = ['group_id', 'feature_id', 'value_id', 'product_id'];
    
    public $timestamps = false;
    
    public function group()
    {
        return $this->hasOne(ProductGroup::class, 'id', 'group_id');
    }
    
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    
    public function feature()
    {
        return $this->hasOne(Feature::class, 'id', 'feature_id');
    }
    
    public function value()
    {
        return $this->hasOne(FeatureValue::class, 'id', 'value_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'group_id', 'group_id');
    }
    
    public function same()
    {
        return $this->hasMany(ProductGroupFeatureValue::class, 'group_id', 'group_id');
    }
    
    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(SearchGroupsFilter::class);
    }
    
    /**
     * @param ProductGroup $group
     * @return array
     */
    public static function getLinkedFeaturesAsArray(ProductGroup $group): array
    {
        $featuresIds = [];
        if ($group && $group->exists) {
            ProductGroupFeatureValue::whereGroupId($group->id)
                ->get()
                ->each(function (ProductGroupFeatureValue $relation) use (&$featuresIds) {
                    $ids = $featuresIds[$relation->feature_id] ?? [];
                    $ids[] = $relation->value_id;
                    $featuresIds[$relation->feature_id] = $ids;
                });
        }
        return $featuresIds;
    }
    
    /**
     * @param ProductGroup[] $groups
     * @return array
     */
    public static function getLinkedFeaturesAsArrayForGroups($groups): array
    {
        $featuresIds = [];
        if ($groups && count($groups) > 0) {
            $groupsIds = [];
            foreach ($groups as $group) {
                $groupsIds[] = $group->id;
            }
            ProductGroupFeatureValue::whereIn('group_id', $groupsIds)
                ->get()
                ->each(function (ProductGroupFeatureValue $relation) use (&$featuresIds) {
                    $features = $featuresIds[$relation->group_id] ?? [];
                    $ids = $features[$relation->feature_id] ?? [];
                    $ids[] = $relation->value_id;
                    $featuresIds[$relation->group_id][$relation->feature_id] = $ids;
                });
        }
        return $featuresIds;
    }
    
    /**
     * @param int $groupId
     * @param int $productId
     * @param int $featureId
     * @param int $valueId
     * @return Model
     */
    public static function linkByIds(int $groupId, int $productId, int $featureId, int $valueId): Model
    {
        $relation = ProductGroupFeatureValue::updateOrCreate([
            'group_id' => $groupId,
            'feature_id' => $featureId,
            'value_id' => $valueId,
            'product_id' => $productId,
        ]);
        return $relation;
    }
    
    /**
     * @param ProductGroup $group
     * @param Product $product
     * @param int $featureId
     * @param int $valueId
     * @return ProductGroupFeatureValue|Model
     */
    public static function link(ProductGroup $group, Product $product, int $featureId, int $valueId): Model
    {
        return ProductGroupFeatureValue::linkByIds($group->id, $product->id, $featureId, $valueId);
    }

    /**
     * Unlink product, value and feature
     *
     * @param int $featureId
     * @param ProductGroup $group
     * @param Product $product
     * @param int|null $valueId
     * @return bool
     * @throws \Exception
     */
    public static function unlink(ProductGroup $group, Product $product, int $featureId, ?int $valueId = null): bool
    {
        $query = ProductGroupFeatureValue::whereGroupId($group->id)
            ->whereProductId($product->id)
            ->whereFeatureId($featureId);
        if ($valueId) {
            $query->whereValueId($valueId);
        }
        return $query->delete();
    }
    
    /**
     * @param ProductGroup $group
     * @param Product $product
     * @param FeatureValue $valueToRemove
     * @param FeatureValue $valueToAdd
     * @throws \Exception
     */
    public static function change(ProductGroup $group, Product $product, ?FeatureValue $valueToRemove, ?FeatureValue $valueToAdd): void
    {
        if ($valueToRemove && $valueToAdd && $valueToAdd->id === $valueToRemove->id) {
            return;
        }
        if ($valueToRemove) {
            ProductGroupFeatureValue::unlink($group, $product, $valueToRemove->feature_id, $valueToRemove->id);
        }
        if ($valueToAdd) {
            ProductGroupFeatureValue::link($group, $product, $valueToAdd->feature_id, $valueToAdd->id);
        }
    }
    
    /**
     * @param ProductGroup $group
     * @param Product $product
     * @param int $featureId
     * @param int $valueId
     */
    public static function changeSingleValue(ProductGroup $group, Product $product, int $featureId, int $valueId): void
    {
        $old = ProductGroupFeatureValue::whereGroupId($group->id)
            ->whereProductId($product->id)
            ->whereFeatureId($featureId)
            ->first();
        if ($old) {
            $old->update([
                'value_id' => $valueId,
            ]);
        } else {
            ProductGroupFeatureValue::create([
                'group_id' => $group->id,
                'product_id' => $product->id,
                'feature_id' => $featureId,
                'value_id' => $valueId,
            ]);
        }
    }

}
