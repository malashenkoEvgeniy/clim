<?php

namespace App\Modules\Orders\Models;

use App\Modules\Products\Models\Product;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Orders\Models\CartItem
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $quantity
 * @property int $cart_id
 * @property int $product_id
 * @property-read \App\Modules\Orders\Models\Cart $cart
 * @property-read \App\Modules\Products\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem whereCartId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $dictionary_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\CartItem whereDictionaryId($value)
 */
class CartItem extends Model
{
    use EloquentTentacle;
    
    protected $table = 'carts_items';
    
    protected $fillable = ['quantity', 'cart_id', 'product_id', 'dictionary_id'];
    
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
