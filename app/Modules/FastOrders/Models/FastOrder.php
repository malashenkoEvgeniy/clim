<?php

namespace App\Modules\FastOrders\Models;

use App\Modules\FastOrders\Filters\FastOrdersFilter;
use App\Modules\Products\Models\Product;
use App\Modules\Users\Models\User;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\FastOrders\Models\FastOrder
 *
 * @property int $id
 * @property string $phone
 * @property string|null $name
 * @property string $ip
 * @property int $product_id
 * @property int|null $user_id
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\Products\Models\Product $product
 * @property-read \App\Modules\Users\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\FastOrders\Models\FastOrder whereUserId($value)
 * @mixin \Eloquent
 */
class FastOrder extends Model
{
    use Filterable;

    protected $table = 'fast_orders';

    protected $casts = ['active' => 'boolean'];

    protected $fillable = ['phone', 'product_id', 'user_id', 'ip', 'active'];

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(FastOrdersFilter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return FastOrder::filter(request()->all())
            ->latest()->paginate(config('db.fast_orders.per-page', 10));
    }
}
