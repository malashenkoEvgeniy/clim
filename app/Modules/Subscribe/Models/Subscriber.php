<?php

namespace App\Modules\Subscribe\Models;

use App\Modules\Subscribe\Filters\SubscribeFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Modules\Subscribe\Models\Subscriber
 *
 * @property int $id
 * @property bool $active
 * @property string|null $ip
 * @property string $email
 * @property string $hash
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Subscribe\Models\Subscriber whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Subscriber extends Model
{
    use Filterable;

    protected $casts = ['active' => 'boolean'];
    
    protected $fillable = ['ip', 'email', 'name', 'active'];

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(SubscribeFilter::class);
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getList()
    {
        return Subscriber::filter(request()->all())
            ->latest()->paginate(config('db.subscribe.per-page', 10));
    }
    
    /**
     * Create subscriber by admin
     *
     * @return bool
     */
    public function createByAdmin()
    {
        $this->fill(request()->only('email', 'name', 'ip', 'active'));
        $this->generateHash();
        return $this->save();
    }
    
    /**
     * Update subscriber by admin
     *
     * @return bool
     */
    public function updateByAdmin()
    {
        $this->fill(request()->only('email', 'name', 'ip', 'active'));
        return $this->save();
    }
    
    /**
     * Set hash for current subscriber
     */
    public function generateHash()
    {
        $this->hash = bcrypt($this->email . $this->ip . str_random(10));
    }
    
    /**
     * Scope for active subscribers
     *
     * @return Subscriber
     */
    public function scopeActive()
    {
        return $this->where('active', '=', 1);
    }
    
    /**
     * List of the subscribers
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function getActiveSubscribers()
    {
        return Subscriber::active()->get();
    }
    
    /**
     * Count of subscribers
     *
     * @return int
     */
    public function countActiveSubscribers()
    {
        return Subscriber::active()->count();
    }
    
    /**
     * Add subscriber ot the database
     *
     * @return bool
     */
    public static function registration(): bool
    {
        $subscriber = Subscriber::whereEmail(request()->input('email'))->first();
        if (!$subscriber) {
            $subscriber = new Subscriber();
            $subscriber->fill(request()->only('name', 'email'));
            $subscriber->active = true;
            $subscriber->generateHash();
            $subscriber->save();
            return true;
        }
        if ($subscriber->active) {
            return false;
        }
        $subscriber->name = request()->input('name', $subscriber->name);
        $subscriber->active = true;
        $subscriber->save();
        return true;
    }
    
    public static function getRecipients(): array
    {
        $recipients = [];
        Subscriber::active()
            ->select('email')
            ->get()
            ->each(function (Subscriber $subscriber) use (&$recipients) {
                $recipients[] = $subscriber->email;
            });
        return $recipients;
    }
}
