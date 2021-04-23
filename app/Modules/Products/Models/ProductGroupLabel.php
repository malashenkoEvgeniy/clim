<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Modules\Products\Models\ProductGroupLabel
 *
 * @property int $id
 * @property int $group_id
 * @property int $label_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupLabel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupLabel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupLabel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupLabel whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupLabel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupLabel whereLabelId($value)
 * @mixin \Eloquent
 */
class ProductGroupLabel extends Model
{
    protected $table = 'products_groups_labels';

    protected $fillable = ['group_id', 'label_id'];

    public $timestamps = false;

    /**
     * @param int $groupId
     * @return Collection|ProductGroupLabel[]
     */
    public static function getRelationsForProduct(int $groupId): Collection
    {
        return ProductGroupLabel::whereGroupId($groupId)->latest('id')->get();
    }
}
