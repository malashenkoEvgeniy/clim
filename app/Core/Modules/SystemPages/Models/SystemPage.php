<?php

namespace App\Core\Modules\SystemPages\Models;

use App\Core\Modules\SystemPages\Filters\SystemPagesFilter;
use App\Traits\ModelMain;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Modules\SystemPages\Models\SystemPage
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Core\Modules\SystemPages\Models\SystemPageTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\SystemPages\Models\SystemPageTranslates[] $data
 * @property-read string $route
 * @property-read mixed $seo_block_needed
 * @property-read string $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\SystemPages\Models\SystemPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SystemPage extends Model
{
    use ModelMain, Filterable;
    
    protected $table = 'system_pages';
    
    protected $fillable = ['updated_at'];

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(SystemPagesFilter::class);
    }

    /**
     * Get list of system pages
     *
     * @return SystemPage[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public function getList()
    {
        return static::with(['current'])
            ->filter(request()->all())
            ->select($this->getTable() . '.*')
            ->oldest($this->getTable() . '.id')
            ->get();
    }
    
    /**
     * Current system page route
     *
     * @return string
     */
    public function getRouteAttribute()
    {
        if ($this->current->slug === 'index-' . config('app.locale')) {
            return 'main';
        }
        return 'system_pages';
    }
    
    /**
     * Current system page url
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        if ($this->current->slug === 'index') {
            return url('/');
        }
        return url(str_replace('::', '-', $this->current->slug));
    }
    
    public function getSeoBlockNeededAttribute()
    {
        $seoText = strip_tags($this->current->content);
        $seoText = trim($seoText);
        return $this->current->h1 || $seoText;
    }
}
