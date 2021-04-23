<?php

namespace App\Modules\ProductsServices\Models;

use App\Traits\ActiveScopeTrait;
use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\ProductsServices\Models\ProductService
 *
 * @property int $id
 * @property bool $active
 * @property int $position
 * @property bool $system
 * @property bool $show_icon
 * @property string|null $icon
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\ProductsServices\Models\ProductServiceTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\ProductsServices\Models\ProductServiceTranslates[] $data
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService whereShowIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService whereSystem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsServices\Models\ProductService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductService extends Model
{
    use ModelMain, ActiveScopeTrait;
    
    protected $table = 'products_services';

    protected $casts = ['show_icon' => 'boolean', 'system' => 'boolean', 'active' => 'boolean'];
    
    protected $fillable = ['show_icon', 'active', 'position'];
    
    protected $guarded = ['system', 'icon'];
    
    /**
     * @return ProductService[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getList()
    {
        return ProductService::orderBy('position')->get();
    }
}
