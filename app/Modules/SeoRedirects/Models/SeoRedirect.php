<?php

namespace App\Modules\SeoRedirects\Models;

use App\Modules\SeoRedirects\Filters\SeoRedirectsFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\SeoRedirects\Models\SeoRedirect
 *
 * @property int $id
 * @property string $link_from
 * @property string $link_to
 * @property int $type
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereLinkFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereLinkTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SeoRedirects\Models\SeoRedirect whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SeoRedirect extends Model
{
    use Filterable;

    protected $casts = ['active' => 'boolean'];

    protected $fillable = ['link_from', 'link_to', 'type', 'active'];

    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(SeoRedirectsFilter::class);
    }

    /**
     * @return mixed
     */
    public static function getList()
    {
        return SeoRedirect::filter(request()->only('link_from', 'link_to', 'type', 'active'))
            ->latest('id')
            ->paginate(config('db.seo_redirects.per-page', 10));
    }

    /**
     * @param $url
     * @return SeoRedirect|\Illuminate\Database\Eloquent\Builder|Model|null|object
     */
    public static function getWhereUrl($url)
    {
        return SeoRedirect::whereLinkFrom($url)->whereActive(true)->first();
    }
}
