<?php

namespace App\Modules\Comments\Models;

use App\Modules\Comments\Filters\CommentFilter;
use App\Modules\Comments\Requests\AdminCommentRequest;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Auth;

/**
 * App\Modules\Comments\Models\Comment
 *
 * @property int $id
 * @property string $commentable_type Type of the comment (catalog, reviews etc.)
 * @property int|null $commentable_id ID of the related row
 * @property int|null $user_id ID of the user
 * @property string|null $name Client name
 * @property string $comment Client comment
 * @property string $email Client email
 * @property int|null $mark
 * @property bool $active
 * @property \Illuminate\Support\Carbon $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $answer Admin answer
 * @property \Illuminate\Support\Carbon|null $answered_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read string|null $answer_date
 * @property-read string|null $commentable_element
 * @property-read null|string $publish_date
 * @property-read \Model|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment published()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereAnsweredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Comments\Models\Comment whereUserId($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use Filterable;
    
    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = [
        'user_id', 'answered_at', 'answer', 'name', 'email',
        'comment', 'active', 'published_at', 'mark',
    ];
    
    protected $dates = ['published_at', 'answered_at'];
    
    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(CommentFilter::class);
    }
    
    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
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
     * @return Model|null
     */
    public function getUserAttribute(): ?Model
    {
        $userModel = config('auth.providers.users.model');
        if (!$userModel) {
            return null;
        }
        return $userModel::find($this->user_id);
    }
    
    /**
     * Published at formatted
     *
     * @return null|string
     */
    public function getPublishDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('Y-m-d, H:i') : null;
    }
    
    /**
     * @return string|null
     */
    public function getAnswerDateAttribute()
    {
        return $this->answered_at ? $this->answered_at->format('Y-m-d, H:i') : null;
    }
    
    /**
     * Get list of reviews
     *
     * @param  string $type
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList(string $type)
    {
        return Comment::whereCommentableType($type)
            ->filter(request()->all())
            ->latest('id')
            ->paginate(config("db.comments.$type-per-page", 10));
    }
    
    /**
     * @param int $commentableId
     * @param string $commentableType
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getListForCommentable(int $commentableId, string $commentableType)
    {
        return Comment::whereCommentableType($commentableType)
            ->whereCommentableId($commentableId)
            ->where('active', true)
            ->where('published_at', '<=', Carbon::now())
            ->latest('published_at')
            ->offset((int)request()->input('page') ?: 0)
            ->paginate(config("db.comments.$commentableType-per-page-site", 10));
    }
    
    /**
     * Create new comment
     *
     * @param  string $morphClassName
     * @param  AdminCommentRequest $request
     * @return Comment
     */
    public static function createAndLink(string $morphClassName, AdminCommentRequest $request): Comment
    {
        // new instance
        $comment = new Comment();
        // Fill new data
        $comment->fill($request->all());
        // Find relation
        $relation = $morphClassName::find($request->input('commentable_id'));
        // Create new page
        $comment = $relation->comments()->save($comment);
        // Comment instance
        return $comment;
    }
    
    public static function createByUser(): Comment
    {
        $comment = new Comment();
        $comment->fill(request()->only('name', 'email', 'mark'));
        $comment->comment = nl2br(request()->input('comment'));
        $comment->commentable_id = request()->input('commentable_id');
        $comment->commentable_type = request()->input('commentable_type');
        $comment->published_at = Carbon::now();
        $comment->active = false;
        $comment->user_id = Auth::id();
        $comment->save();
        
        return $comment;
    }
    
    /**
     * Update comment
     *
     * @param  AdminCommentRequest $request
     * @return bool
     */
    public function updateComment(AdminCommentRequest $request)
    {
        // Fill simple data
        $this->fill($request->only([
            'user_id', 'name', 'email', 'comment', 'active', 'published_at', 'mark',
            'answer', 'answered_at'
        ]));
        // Change commentable ID
        $this->commentable_id = $request->input('commentable_id');
        return $this->save();
    }
    
    /**
     * @return string|null
     */
    public function getCommentableElementAttribute(): ?string
    {
        if (!$this->commentable_id) {
            return null;
        }
        $morphClassName = Comment::getActualClassNameForMorph($this->commentable_type);
        return $morphClassName::getElementForList($this->commentable_id);
    }
}
