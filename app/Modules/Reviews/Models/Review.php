<?php

namespace App\Modules\Reviews\Models;

use App\Modules\Reviews\Filters\ReviewsFilter;
use App\Traits\ActiveScopeTrait;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Reviews\Models\Review
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $comment
 * @property bool $active
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read null|string $publish_date
 * @property-read mixed $user
 * @property-write mixed $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review active($active = true)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Reviews\Models\Review withoutPublishingInFeature()
 * @mixin \Eloquent
 */
class Review extends Model
{
    use Filterable, ActiveScopeTrait;
    
    const WIDGET_LIMIT = 5;

    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['user_id', 'name', 'email', 'comment', 'published_at'];
    
    protected $dates = ['published_at'];
    
    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(ReviewsFilter::class);
    }
    
    public function getUserAttribute(): ?Model
    {
        $userModel = config('auth.providers.users.model');
        if (!$userModel) {
            return null;
        }
        return $userModel::find($this->user_id);
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
     * Published at formatted
     *
     * @return null|string
     */
    public function getPublishDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('Y-m-d H:i') : null;
    }
    
    /**
     * Set default active status attribute
     *
     * @param $value
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['active'] = (bool)$value;
    }
    
    /**
     * Get list of reviews
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return Review::filter(request()->all())
            ->latest('published_at')
            ->latest('id')
            ->paginate(config('db.reviews.per-page', 10));
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
     * Reviews list for widget
     *
     * @return Review[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection
     */
    public static function forWidget()
    {
        return Review::published()
            ->withoutPublishingInFeature()
            ->limit(config('db.reviews.count-in-widget', Review::WIDGET_LIMIT))
            ->latest('published_at')
            ->get();
    }
    
    /**
     * Paginated list of reviews
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getReviewsForClientSide()
    {
        return Review::published()
            ->withoutPublishingInFeature()
            ->latest('published_at')
            ->latest('id')
            ->paginate(config('db.reviews.per-page-client-side', 10));
    }
    
}
