<?php

namespace App\Modules\Orders\Models;

use App\Modules\Orders\Requests\OrderItemRequest;
use Illuminate\Database\Eloquent\Model;
use Catalog;

/**
 * App\Modules\Orders\Models\OrderItem
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $order_id
 * @property int $product_id
 * @property int $quantity
 * @property float $price
 * @property float|null $old_price
 * @property-read mixed $formatted_amount
 * @property-read mixed $formatted_price
 * @property-read \App\Modules\Orders\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem whereOldPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $dictionary_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderItem whereDictionaryId($value)
 */
class OrderItem extends Model
{
    protected $table = 'orders_items';
    
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price', 'old_price', 'dictionary_id'];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    
    public static function store(array $item): OrderItem
    {
        return OrderItem::create($item);
    }
    
    public function getFormattedPriceAttribute(): string
    {
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->format($this->price);
        }
        return $this->price;
    }
    
    public function getFormattedAmountAttribute(): string
    {
        $amount = $this->price * $this->quantity;
        if (Catalog::currenciesLoaded()) {
            return Catalog::currency()->format($amount);
        }
        return $amount;
    }
    
    public static function addByAdministrator(int $orderId, OrderItemRequest $request): OrderItem
    {
        $config = config('db.products_dictionary.site_status', 0);
        if ($config) {
            $orderItem = new OrderItem;
            $price = $request->input('price');
            $orderItem->fill([
                'order_id' => $orderId,
                'product_id' => $request->input('product_id'),
                'quantity' => $request->input('quantity'),
                'price' => $price ?? 0,
            ]);
        } else {
            $orderItem = OrderItem::whereProductId($request->input('product_id'))->whereOrderId($orderId)->first();
            if (!$orderItem) {
                $orderItem = new OrderItem;
                $price = $request->input('price');
                $orderItem->fill([
                    'order_id' => $orderId,
                    'product_id' => $request->input('product_id'),
                    'quantity' => $request->input('quantity'),
                    'price' => $price ?? 0,
                ]);
            } else {
                $orderItem->quantity += $request->input('quantity');
            }
        }
        $orderItem->save();
        return $orderItem;
    }
    
    public function updateQuantity(int $quantity, int $id)
    {
        if ($quantity === $this->quantity) {
            return;
        }
        if ($this->id === $id) {
            $this->quantity = $quantity;
            $this->save();
        }
    }
    
    public function updateDictionary($dictionary, int $id)
    {
        if (!isset($dictionary)) {
            return;
        }
        if ($dictionary === $this->dictionary_id) {
            return;
        }
        if ($this->id === $id) {
            $this->dictionary_id = $dictionary;
            $this->save();
        }
    }
    
    /**
     * @param int $orderId
     */
    public static function checkSameItems(int $orderId)
    {
        $showDictionaryOnSite = config('db.products_dictionary.site_status', 0);
        $items = OrderItem::whereOrderId($orderId)->get();
        foreach ($items as $item) {
            $sameItems = $items
                ->where('product_id', $item->product_id)
                ->where('id', '!=', $item->id);
            if ($showDictionaryOnSite) {
                $sameItems = $sameItems->where('dictionary_id', $item->dictionary_id);
            }
            foreach ($sameItems as $same) {
                $item->quantity += $same->quantity;
                $item->save();
                
                $same->delete();
            }
        }
        
    }
}
