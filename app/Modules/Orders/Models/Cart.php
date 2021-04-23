<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Orders\Models\Cart
 *
 * @property int $id
 * @property string $hash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Orders\Models\CartItem[] $items
 * @property-read \App\Modules\Orders\Models\CartUnfinishedOrder $unfinishedOrder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Cart whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\Cart whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cart extends Model
{
    protected $fillable = ['hash'];
    
    public function items()
    {
        return $this
            ->hasMany(CartItem::class, 'cart_id', 'id')
            ->latest('id');
    }
    
    public function unfinishedOrder()
    {
        return $this->hasOne(CartUnfinishedOrder::class, 'cart_id', 'id');
    }
}