<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Orders\Models\CartUnfinishedOrder
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $information
 * @property int|null $cart_id
 * @property-read \App\Modules\Orders\Models\Cart|null $cart
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartUnfinishedOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartUnfinishedOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartUnfinishedOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartUnfinishedOrder whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartUnfinishedOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartUnfinishedOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartUnfinishedOrder whereInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartUnfinishedOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CartUnfinishedOrder extends Model
{
    protected $table = 'carts_unfinished_orders';
    
    protected $casts = ['information' => 'array'];
    
    protected $fillable = ['information'];
    
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }
}