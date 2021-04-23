<?php

namespace App\Core\Modules\Notifications\Models;

use App\Core\Modules\Notifications\Filters\NotificationsFilter;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

/**
 * App\Core\Modules\Notifications\Models\Notification
 *
 * @property int $id
 * @property string $name
 * @property string|null $route
 * @property array|null $parameters
 * @property string|null $type
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Notifications\Models\Notification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Notification extends Model
{
    use Filterable;
    
    protected $table = 'notifications';
    
    protected $casts = ['active' => 'boolean', 'parameters' => 'array'];
    
    protected $fillable = ['active'];
    
    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(NotificationsFilter::class);
    }
    
    /**
     * Returns list of some last notifications
     *
     * @return mixed
     */
    public static function getList()
    {
        /** @var Notification[]|LengthAwarePaginator $notifications */
        $notifications = Notification::filter(request()->only('created_at'))
            ->latest('id')
            ->paginate(config('db.notifications.per-page', 10));
        $noActive = [];
        foreach ($notifications as $notification) {
            if ($notification->active === false) {
                $noActive[] = $notification->id;
            }
        }
        if (count($noActive)) {
            Notification::whereIn('id', $noActive)->update(['active' => true]);
        }
        return $notifications;
    }
    
    /**
     * Elements for widget
     *
     * @return Notification[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getListForWidget()
    {
        return Notification::latest('id')
            ->whereActive(false)
            ->get();
    }
    
    /**
     * @param string $type
     * @param string $name
     * @param string|null $routeName
     * @param array $routeParameters
     * @return Notification
     */
    public static function send(string $type, string $name, ?string $routeName = null, array $routeParameters = [])
    {
        if (Str::length($name) > 190) {
            $name = Str::substr($name, 0, 150) . '...';
        }
        
        $notification = new Notification();
        $notification->type = $type;
        $notification->route = $routeName;
        $notification->name = Str::substr($name, 0, 190);
        $notification->parameters = $routeParameters;
        $notification->save();
        
        return $notification;
    }
}
