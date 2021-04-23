<?php

namespace App\Modules\ProductsAvailability\Models;

use App\Modules\ProductsAvailability\Filters\ProductsAvailabilityFilter;
use App\Modules\Products\Models\Product;
use App\Modules\Users\Models\User;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Modules\ProductsAvailability\Models\ProductsAvailability
 *
 * @property int $id
 * @property string $email
 * @property int $product_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Modules\Products\Models\Product $product
 * @property-read \App\Modules\Users\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability filter($input = array(), $filter = null)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\ProductsAvailability\Models\ProductsAvailability withoutTrashed()
 * @mixin \Eloquent
 */
class ProductsAvailability extends Model
{
    use Filterable, SoftDeletes;

    protected $table = 'products_availability';

    protected $fillable = ['email', 'product_id', 'user_id'];

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(ProductsAvailabilityFilter::class);
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
        return ProductsAvailability::with('product', 'user')->filter(request()->all())
            ->latest()->paginate(config('db.products_availability.per-page', 10));
    }
}
