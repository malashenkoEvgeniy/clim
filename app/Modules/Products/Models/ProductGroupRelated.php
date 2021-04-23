<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Products\Models\ProductGroupRelated
 *
 * @property int $id
 * @property int $related_id
 * @property int $group_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupRelated newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupRelated newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupRelated query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupRelated whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupRelated whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupRelated whereRelatedId($value)
 * @mixin \Eloquent
 */
class ProductGroupRelated extends Model
{
    protected $table = 'products_groups_related';
    
    public $timestamps = false;
    
    protected $fillable = ['related_id', 'group_id'];
    
    /**
     * @param ProductGroup $group
     * @param ProductGroup $related
     * @return ProductGroupRelated|\Illuminate\Database\Eloquent\Builder|Model
     */
    public static function link(ProductGroup $group, ProductGroup $related)
    {
        return ProductGroupRelated::linkByIds($group->id, $related->id);
    }
    
    /**
     * @param int $groupId
     * @param int $relatedId
     * @return ProductGroupRelated|\Illuminate\Database\Eloquent\Builder|Model
     */
    public static function linkByIds(int $groupId, int $relatedId)
    {
        return ProductGroupRelated::whereRelatedId($relatedId)
            ->whereGroupId($groupId)
            ->firstOrCreate([
                'related_id' => $relatedId,
                'group_id' => $groupId,
            ]);
    }
    
    /**
     * @param ProductGroup $group
     * @param ProductGroup $related
     * @return bool
     * @throws \Exception
     */
    public static function unlink(ProductGroup $group, ProductGroup $related): bool
    {
        return ProductGroupRelated::whereGroupId($group->id)
            ->whereRelatedId($related->id)
            ->delete();
    }
    
}
