<?php

namespace App\Modules\Orders\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderStatusesHistoryTranslates
 *
 * @property int $id
 * @property string $name
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\Orders\Models\OrderStatusesHistory $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistoryTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistoryTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistoryTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistoryTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistoryTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistoryTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusesHistoryTranslates whereRowId($value)
 * @mixin \Eloquent
 */
class OrderStatusesHistoryTranslates extends Model
{
    use ModelTranslates;
    
    public $timestamps = false;
    
    protected $table = 'orders_statuses_history_translates';
    
    protected $fillable = ['name'];
}