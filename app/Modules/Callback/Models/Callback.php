<?php

namespace App\Modules\Callback\Models;

use App\Modules\Callback\Filters\CallbackFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Callback\Models\Callback
 *
 * @property int $id
 * @property string|null $name
 * @property string $phone
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Callback\Models\Callback whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Callback extends Model
{
    use Filterable;

    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['name', 'phone', 'active'];

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(CallbackFilter::class);
    }
    
    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return Callback::filter(request()->all())
            ->latest()
            ->paginate(config('db.callback.per-page', 10));
    }
}
