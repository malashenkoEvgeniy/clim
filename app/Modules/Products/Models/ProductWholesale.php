<?php

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Modules\Products\Models\ProductWholesale
 *
 * @property int $id
 * @property int $product_id
 * @property int $quantity
 * @property float $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Products\Models\ProductWholesale whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductWholesale extends Model
{
    protected $table = 'products_wholesale';

    protected $fillable = ['product_id', 'quantity', 'price'];
}
