<?php

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Orders\Models\OrderClient
 *
 * @property int $id
 * @property int $order_id
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property-read mixed $cleared_phone
 * @property-read \App\Modules\Orders\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderClient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderClient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderClient query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderClient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderClient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderClient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderClient whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderClient wherePhone($value)
 * @mixin \Eloquent
 */
class OrderClient extends Model
{
    protected $table = 'orders_clients';
    
    public $timestamps = false;
    
    protected $fillable = ['order_id', 'name', 'phone', 'email'];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    
    public function getClearedPhoneAttribute()
    {
        return preg_replace('/[^0-9]*/', '', $this->phone);
    }
    
    public static function store(int $orderId, ?string $name = null, ?string $phone = null, ?string $email = null): OrderClient
    {
        $client = new OrderClient;
        $client->order_id = $orderId;
        $client->name = $name;
        $client->phone = $phone;
        $client->email = $email;
        $client->save();
        
        return $client;
    }
}