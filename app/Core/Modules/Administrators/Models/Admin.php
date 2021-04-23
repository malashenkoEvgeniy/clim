<?php

namespace App\Core\Modules\Administrators\Models;

use App\Core\Modules\Administrators\Filters\AdminFilter;
use App\Core\Modules\Administrators\Images\AdminAvatar;
use App\Core\Modules\Languages\Models\Language;
use EloquentFilter\Filterable;
use Hash, Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Imageable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Core\Modules\Administrators\Models\Admin
 *
 * @property int $id
 * @property string $first_name
 * @property string $email
 * @property string $password
 * @property bool $active
 * @property string|null $language
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $allImages
 * @property-read bool $is_super_admin
 * @property-read array $roles_ids
 * @property-read string $roles_names
 * @property-read array $rules
 * @property-read \App\Core\Modules\Images\Models\Image $image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Images\Models\Image[] $images
 * @property-read \App\Core\Modules\Languages\Models\Language|null $lang
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Administrators\Models\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin filter($input = array(), $filter = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin paginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin simplePaginateFilter($perPage = null, $columns = array(), $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereBeginsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereEndsWith($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereLike($column, $value, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Admin whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Authenticatable
{
    use Imageable, Notifiable, Filterable;
    
    protected $casts = ['active' => 'boolean'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'email', 'password', 'language'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    
    /**
     * Register filter model
     *
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(AdminFilter::class);
    }
    
    /**
     * Image config
     *
     * @return string|array
     */
    protected function imageClass()
    {
        return AdminAvatar::class;
    }
    
    /**
     * Current administrators language of interface
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lang()
    {
        return $this->belongsTo(Language::class, 'language', 'slug')->withDefault();
    }
    
    /**
     * Get roles list
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function roles()
    {
        return $this->hasManyThrough(
            Role::class,
            AdminRole::class,
            'admin_id',
            'id',
            'id',
            'role_id'
        );
    }
    
    /**
     * Update admins password
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
     * Update user information
     *
     * @param  array $attributes
     * @throws \Throwable
     */
    public function updateInformation(array $attributes = [])
    {
        $this->first_name = data_get($attributes, 'first_name');
        $this->email = data_get($attributes, 'email');
        $this->active = data_get($attributes, 'active', $this->active);
        if (isset($attributes['password']) && $attributes['password']) {
            $this->password = $attributes['password'];
        }
        // Save data
        $this->saveOrFail();
        // Upload image
        $this->updateImage();
        // Old roles deleting
        AdminRole::deleteFor($this->id);
        // Link new roles
        foreach (array_get($attributes, 'roles', []) as $roleId) {
            AdminRole::link($this->id, $roleId);
        }
    }
    
    /**
     * Register new user
     *
     * @param  array $attributes
     * @return Admin
     * @throws \Throwable
     */
    static function register(array $attributes = [])
    {
        // Create admin
        $admin = new Admin();
        $attributes['active'] = data_get($attributes, 'active', false);
        $admin->updateInformation($attributes);
        // Link new roles
        foreach (array_get($attributes, 'roles', []) as $roleId) {
            AdminRole::link($admin->id, $roleId);
        }
        // Return admin model
        return $admin;
    }
    
    /**
     * Get users list to show
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    static function forList()
    {
        $ignore = Role::getSuperadminsIds();
        $ignore[] = Auth::user()->id;
        $admins = Admin::whereNotIn('id', $ignore);
        return $admins->filter(request()->only('first_name', 'email'))
            ->orderBy('id', 'DESC')
            ->paginate(config('db.admins.per-page', 10));
    }
    
    /**
     * Check if user is superadmin
     *
     * @return bool
     */
    public function getIsSuperAdminAttribute()
    {
        return $this->hasRole(Role::SUPERADMIN);
    }
    
    /**
     * Returns all rules for current role
     *
     * @return array
     */
    public function getRulesAttribute()
    {
        $rules = [];
        foreach ($this->roles as $role) {
            foreach ($role->rules as $rule) {
                if (array_key_exists($rule->module, $rules)) {
                    foreach ($rule->toArray() as $scope => $access) {
                        $rules[$rule->module][$scope] = array_get($rules[$rule->module], $scope, false) || $access;
                    }
                } else {
                    $rules[$rule->module] = $rule->toArray();
                }
            }
        }
        return $rules;
    }
    
    /**
     * Check for access
     *
     * @param  string $module
     * @param  string|null $action
     * @return mixed
     */
    public function hasPermissions(string $module, string $action)
    {
        // Check if user is superadmin
        if ($this->is_super_admin) {
            return true;
        }
        // Generate scope
        $scope = $module . '.' . \CustomRoles::getRuleName($module, $action);
        // Check permissions
        return array_get($this->rules, $scope, false);
    }
    
    /**
     * Check if user is superadmin
     *
     * @param  string $role
     * @return bool
     */
    public function hasRole(string $role)
    {
        foreach ($this->roles as $adminRole) {
            if ($adminRole->alias === $role) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Get roles ids only
     *
     * @return array
     */
    public function getRolesIdsAttribute()
    {
        $ids = [];
        $this->roles->each(
            function (Role $role) use (&$ids) {
                $ids[] = $role->id;
            }
        );
        return array_unique($ids);
    }
    
    /**
     * Get roles names only
     *
     * @return string
     */
    public function getRolesNamesAttribute()
    {
        $names = [];
        $this->roles->each(
            function (Role $role) use (&$names) {
                $names[] = $role->name;
            }
        );
        return implode(', ', array_unique($names)) ?: __('admins::roles.no-role');
    }
    
    /**
     * Check if current logged administrator could edit/delete chosen admin
     *
     * @return bool
     */
    public function couldBeEdited()
    {
        return Auth::user()->id !== $this->id && !$this->hasRole(Role::SUPERADMIN);
    }
    
}
