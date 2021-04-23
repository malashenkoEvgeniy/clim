<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Products\Models\ProductGroupCategory
 *
 * @property int $id
 * @property int $category_id
 * @property int $group_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupCategory whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductGroupCategory whereId($value)
 * @mixin \Eloquent
 */
class ProductGroupCategory extends Model
{
    protected $table = 'products_groups_categories';
    
    protected $fillable = ['group_id', 'category_id'];
    
    public $timestamps = false;
}
