<?php

namespace App\Modules\Orders\Models;

use App\Traits\ModelMain;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderStatusesHistory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $color
 * @property string|null $comment
 * @property int $order_id
 * @property-read \App\Modules\Orders\Models\OrderStatusesHistoryTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Orders\Models\OrderStatusesHistoryTranslates[] $data
 * @property-read \App\Modules\Orders\Models\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderStatusesHistory extends Model
{
    use ModelMain;
    
    protected $table = 'orders_statuses_history';
    
    protected $fillable = ['comment', 'order_id', 'color'];
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    
    public static function write(int $orderId, int $statusId, ?string $comment = null): void
    {
        if (!$orderId) {
            return;
        }
        $status = OrderStatus::find($statusId);
        if (!$status) {
            return;
        }
        $history = new OrderStatusesHistory;
        $history->fill([
            'order_id' => $orderId,
            'color' => $status->color ?? '#000000',
            'comment' => $comment,
        ]);
        if ($history->save()) {
            foreach (config('languages', []) AS $language) {
                $translate = new OrderStatusesHistoryTranslates;
                $translate->fill([
                    'name' => $status->dataFor($language['slug'])->name,
                ]);
                $translate->language = $language['slug'];
                $translate->row_id = $history->id;
                $translate->save();
            }
        }
    }
}