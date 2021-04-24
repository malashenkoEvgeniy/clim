<?php

namespace App\Modules\Users\Models;

use App\Core\Modules\Settings\Models\Setting;
use App\Modules\Users\Events\ForgotPasswordEvent;
use App\Modules\users\Filters\UsersFilter;
use Carbon\Carbon;
use EloquentFilter\Filterable;
use Greabock\Tentacles\EloquentTentacle;
use Hash, Event;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Modules\Users\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property bool $active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $phone
 * @property-read string $cleared_phone
 * @property-read string $edit_page_link
 * @property-read string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Users\Models\UserNetwork[] $networks
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User filter($input = array(), $filter = null)
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Users\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Users\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Users\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Users\Models\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes, EloquentTentacle, Filterable;

    const DEFAULT_USERS_LIMIT = 10;

    protected $casts = ['active' => 'boolean'];

    protected $dates = ['deleted_at'];

    public function sendPasswordResetNotification($token)
    {
        Event::fire(new ForgotPasswordEvent($this->email, $token));
    }

    public function networks()
    {
        return $this->hasMany(UserNetwork::class, 'user_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'phone', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function modelFilter()
    {
        return $this->provideFilter(UsersFilter::class);
    }

    /**
     * Update users password
     *
     * @param  $password
     * @return bool
     * @throws \Throwable
     */
    public function updatePassword(string $password)
    {
        $this->password = $password;
        return $this->save();
    }


    public function updatePhone(string $phone)
    {
        $this->phone = $phone;
        return $this->save();
    }

    /**
     * Password mutator
     *
     * @param string $password
     */
    public function setPasswordAttribute(string $password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    /**
     * Form name from last and first names
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Update user information
     *
     * @param  array $attributes
     * @throws \Throwable
     */
    public function updateInformation(array $attributes = [])
    {
        $this->first_name = data_get($attributes, 'first_name');
        $this->last_name = data_get($attributes, 'last_name');
        $this->email = data_get($attributes, 'email');
        $this->phone = data_get($attributes, 'phone');
        $this->active = data_get($attributes, 'active', $this->active);
        if (isset($attributes['password']) && $attributes['password']) {
            $this->password = $attributes['password'];
        }
        $this->saveOrFail();
    }

    /**
     * Register new user
     *
     * @param  array $attributes
     * @return User
     * @throws \Throwable
     */
    static function register(array $attributes = [])
    {
        $user = new User();
        $attributes['active'] = data_get($attributes, 'active', false);
        $user->updateInformation($attributes);
        return $user;
    }

    /**
     * Get users list to show
     *
     * @param  bool $trashed
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    static function forList($trashed = false)
    {
        $users = User::filter(request()->all())->where('id', '>', 0);
        if ($trashed === true) {
            $users->onlyTrashed();
        }
        return $users->latest('id')->paginate(config('db.users.per-page', static::DEFAULT_USERS_LIMIT));
    }

    /**
     * Trashed users list
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    static function trashedList()
    {
        return User::forList(true);
    }

    /**
     * List uf pairs user_id => user_name
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    static function dictionary()
    {
        return User::all()->mapWithKeys(
            function (User $user) {
                return [$user->id => '[' . $user->id . '] ' . $user->name];
            }
        )->toArray();
    }

    /**
     * Available users list to choose by admin
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    static function available()
    {
        return User::all();
    }

    /**
     * Link to edit page in admin panel
     *
     * @return string
     */
    public function getEditPageLinkAttribute(): string
    {
        return route('admin.users.edit', $this->id);
    }

    /**
     * Phone number without anything except numbers
     *
     * @return string
     */
    public function getClearedPhoneAttribute(): string
    {
        return preg_replace('/[^0-9]*/', '', $this->phone);
    }

    /**
     * @return array
     */
    public static function getSettingsForSocialsLogin(): array
    {
        $socialSettings = Setting::whereGroup('socials-login')->get()->keyBy('alias')->map(function ($setting) {
            return $setting->value;
        })->toArray();
        $checkSocials = [];
        foreach ((array)config('users.socials', []) as $socialName => $setting) {
            $apiIndex = $socialName . '-api-key';
            $secretIndex = $socialName . '-api-secret';
            if (array_get($socialSettings, $apiIndex) && array_get($socialSettings, $secretIndex)) {
                $checkSocials[$socialName] = [
                    $apiIndex => $socialSettings[$apiIndex],
                    $secretIndex => $socialSettings[$secretIndex],
                ];
            }
        }
        return $checkSocials;
    }

}
