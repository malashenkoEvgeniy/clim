<?php

namespace App\Modules\SeoLinks\Models;

use App\Modules\SeoLinks\Filters\SeoLinksFilter;
use App\Traits\ModelMain;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SeoLinks\Models\SeoLink
 *
 * @property int $id
 * @property string $url
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Modules\SeoLinks\Models\SeoLinkTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SeoLinks\Models\SeoLinkTranslates[] $data
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoLinks\Models\SeoLink whereUrl($value)
 * @mixin \Eloquent
 */
class SeoLink extends Model
{
    use ModelMain, Filterable;

    protected $fillable = ['name', 'url', 'active'];

    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(SeoLinksFilter::class);
    }

    /**
     * @return mixed
     */
    public static function getList()
    {
        return SeoLink::filter(request()->only('name', 'url', 'active'))
            ->latest('id')
            ->paginate(config('db.seoLinks.per-page', 10));
    }

    /**
     * @param $url
     * @return mixed
     */
    public static function getWhereUrl($url)
    {
        return SeoLink::whereUrl($url)->whereActive(true)->first();
    }
}
