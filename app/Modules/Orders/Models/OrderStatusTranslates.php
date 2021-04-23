<?php

namespace App\Modules\Orders\Models;

use App\Traits\ModelTranslates;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Orders\Models\OrderStatusTranslates
 *
 * @property int $id
 * @property string $name
 * @property int $row_id
 * @property string $language
 * @property-read \App\Core\Modules\Languages\Models\Language $lang
 * @property-read \App\Modules\Orders\Models\OrderStatus $row
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusTranslates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusTranslates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusTranslates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusTranslates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusTranslates whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusTranslates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Orders\Models\OrderStatusTranslates whereRowId($value)
 * @mixin \Eloquent
 */
class OrderStatusTranslates extends Model
{
    use ModelTranslates;
    
    public $timestamps = false;
    
    protected $table = 'orders_statuses_translates';
    
    protected $fillable = ['name'];
}