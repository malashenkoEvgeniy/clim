<?php

namespace App\Modules\News\Models;

use App\Modules\News\Images\NewsImage;
use App\Traits\ActiveScopeTrait;
use App\Traits\ModelMain;
use App\Traits\Imageable;
use Carbon\Carbon;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Model;
use App\Core\Modules\News\Filters\NewsFilter;
use EloquentFilter\Filterable;
use Illuminate\Support\Str;

/**
 * App\Modules\News\Models\News
 *
 * @property int $id
 * @property bool $active
 * @property \Illuminate\Support\Carbon $published_at
 * @property int $show_short_content
 * @property int $show_image
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $allImages
 * @property-read \App\Modules\News\Models\NewsTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\News\Models\NewsTranslates[] $data
 * @property-read null|string $formatted_published_at
 * @property-read string $link
 * @property-read string $teaser
 * @property-read \App\Core\Modules\Images\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $images
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereShowImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereShowShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News whereViews($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\News\Models\News withoutPublishingInFeature()
 * @mixin \Eloquent
 */
class News extends Model
{
    use ModelMain, Imageable, Filterable, EloquentTentacle, ActiveScopeTrait;

    const WIDGET_LIMIT = 4;

    const TEASER_WORDS_LIMIT = 30;

    const SEO_TEMPLATE_ALIAS = 'news';

    protected $casts = ['active' => 'boolean'];

    protected $fillable = ['published_at', 'active', 'show_image', 'show_short_content'];

    protected $dates = ['published_at'];

    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(NewsFilter::class);
    }

    /**
     * Set images upload config
     *
     * @return string|array
     */
    protected function imageClass()
    {
        return NewsImage::class;
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    /**
     * Get list of news
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return News::with(['current'])
            ->filter(request()->only('name', 'published_at', 'active'))
            ->latest('published_at')
            ->latest('id')
            ->paginate(config('db.news.per-page', 10));
    }

    /**
     * Paginated list of users
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getNewsForClientSide()
    {
        return News::with(['current', 'image', 'image.current'])
            ->published()
            ->withoutPublishingInFeature()
            ->latest('published_at')
            ->latest('id')
            ->paginate(config('db.news.per-page-client-side', 10));
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithoutPublishingInFeature($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    /**
     * News list for widget
     *
     * @return News[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function newsForWidget()
    {
        return News::with('current', 'image', 'image.current')
            ->withoutPublishingInFeature()
            ->active(true)
            ->limit(News::WIDGET_LIMIT)
            ->latest('published_at')
            ->latest('id')
            ->get();
    }

    /**
     * News list for widget `same news`
     *
     * @param int|null $exceptNewsId
     * @param int $limit
     * @return News[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function sameNews(?int $exceptNewsId = null, int $limit = 4)
    {
        $news = News::with('current', 'image', 'image.current')
            ->withoutPublishingInFeature()
            ->active(true)
            ->limit($limit)
            ->latest('published_at')
            ->latest('id');
        if ($exceptNewsId) {
           $news->where('id', '!=', $exceptNewsId);
        }
        return $news->get();
    }

    /**
     * Link on the show news inner page
     *
     * @return string
     */
    public function getLinkAttribute(): string
    {
        return route('site.news-inner', [
            'slug' => $this->current->slug,
        ]);
    }

    /**
     * Short description
     *
     * @return string
     */
    public function getTeaserAttribute()
    {
        $teaser = strip_tags($this->current->short_content);
        $teaser = trim($teaser);
        $teaser = Str::words($teaser, News::TEASER_WORDS_LIMIT);
        return $teaser;
    }

    /**
     * Formatted date of publication
     *
     * @return null|string
     */
    public function getFormattedPublishedAtAttribute(): ?string
    {
        return $this->published_at ? $this->published_at->format('d.m.Y') : null;
    }


    /**
     * @param int $id
     * @return array|null
     */
    public function getPagesLinksByIdForImage(int $id)
    {
        $links = [];
        $item = News::published()->active()->find($id);
        if($item){
            $links[] = url(route('site.news-inner', ['slug' => $item->current->slug], false), [], isSecure());
        }
        return $links;
    }

}
