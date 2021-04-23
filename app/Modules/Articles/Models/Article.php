<?php

namespace App\Modules\Articles\Models;

use App\Modules\Articles\Images\ArticlesImage;
use App\Traits\ActiveScopeTrait;
use App\Traits\ModelMain;
use App\Traits\Imageable;
use Greabock\Tentacles\EloquentTentacle;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Articles\Filters\ArticlesFilter;
use EloquentFilter\Filterable;
use Illuminate\Support\Str;

/**
 * App\Modules\Articles\Models\Article
 *
 * @property int $id
 * @property bool $active
 * @property int $show_short_content
 * @property int $show_image
 * @property int $views
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $allImages
 * @property-read \App\Modules\Articles\Models\ArticleTranslates $current
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Articles\Models\ArticleTranslates[] $data
 * @property-read string $link
 * @property-read string $teaser
 * @property-read \App\Core\Modules\Images\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $images
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereShowImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereShowShortContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Articles\Models\Article whereViews($value)
 * @mixin \Eloquent
 */
class Article extends Model
{
    use ModelMain, Imageable, Filterable, EloquentTentacle, ActiveScopeTrait;
    
    const TEASER_WORDS_LIMIT = 30;
    const SEO_TEMPLATE_ALIAS = 'articles';
    
    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['active', 'show_image', 'show_short_content'];
    
    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(ArticlesFilter::class);
    }
    
    /**
     * Image class name
     *
     * @return string|array
     */
    protected function imageClass()
    {
        return ArticlesImage::class;
    }
    
    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('active', '=', true);
    }
    
    /**
     * Get list of news
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return Article::with(['current'])
            ->filter(request()->only('name', 'active'))
            ->latest('id')
            ->paginate(config('db.articles.per-page', 10));
    }
    
    public static function last(?int $ignoreId = null, int $limit = 4)
    {
        $articles = Article::with('current', 'image', 'image.current')
            ->active(true)
            ->limit($limit)
            ->latest('id');
        if ($ignoreId) {
            $articles->where('id', '!=', $ignoreId);
        }
        return $articles->get();
    }
    
    /**
     * Link on the show news inner page
     *
     * @return string
     */
    public function getLinkAttribute(): string
    {
        return route('site.articles-inner', [
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
        $teaser = Str::words($teaser, Article::TEASER_WORDS_LIMIT);
        return $teaser;
    }
    
    public static function getArticlesForClientSide()
    {
        return Article::with(['current', 'image', 'image.current'])
            ->published()
            ->latest('id')
            ->paginate(config('db.articles.per-page-client-side', 10));
    }


    /**
     * @param int $id
     * @return array|null
     */
    public function getPagesLinksByIdForImage(int $id)
    {
        $links = [];
        $item = Article::active()->find($id);
        if($item){
            $links[] = url(route('site.articles-inner', ['slug' => $item->current->slug], false), [], isSecure());
        }
        return $links;
    }
}
