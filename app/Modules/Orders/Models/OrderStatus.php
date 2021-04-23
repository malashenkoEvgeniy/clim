<?php

namespace App\Modules\Orders\Models;

use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Orders\Models\OrderStatus
 *
 * @property int $id
 * @property int $position
 * @property bool $user_can_cancel
 * @property string|null $alias
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Orders\Models\OrderStatusTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Orders\Models\OrderStatusTranslates[] $data
 * @property-read bool $editable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatus whereUserCanCancel($value)
 * @mixin \Eloquent
 */
class OrderStatus extends Model
{
    use ModelMain;

    const STATUS_NEW = 'new';
    const STATUS_DONE = 'done';
    const STATUS_CANCELED = 'canceled';

    protected $table = 'orders_statuses';
    
    protected $casts = ['user_can_cancel' => 'boolean'];
    
    protected $fillable = ['position', 'new_order', 'canceled_order', 'user_can_cancel', 'color'];
    
    /**
     * Checks if we could edit/delete order status
     *
     * @return bool
     */
    public function getEditableAttribute(): bool
    {
        return $this->alias === null;
    }
    
    /**
     * Orders statuses sorted by position list
     *
     * @return OrderStatus[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getList()
    {
        return OrderStatus::with('current')->oldest('position')->get();
    }
    
    public static function newOrder(): ?OrderStatus
    {
        return OrderStatus::whereAlias(static::STATUS_NEW)->first();
    }
}
