<?php

namespace App\Core\Modules\Administrators\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use CustomRoles;

/**
 * App\Core\Modules\Administrators\Models\Role
 *
 * @property int $id
 * @property int $hidden
 * @property int $active
 * @property string $name
 * @property string $alias
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Administrators\Models\Admin[] $admins
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Core\Modules\Administrators\Models\RoleRule[] $rules
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role whereHidden($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\Role whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    
    const SUPERADMIN = 'superadmin';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'module'];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['hidden', 'alias'];
    
    /**
     * Get roles list
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function admins()
    {
        return $this->hasManyThrough(
            Admin::class,
            AdminRole::class,
            'role_id',
            'id',
            'id',
            'admin_id'
        );
    }
    
    /**
     * Rules for current role
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rules()
    {
        return $this->hasMany(RoleRule::class, 'role_id', 'id');
    }
    
    /**
     * Password mutator
     *
     * @param string $name
     */
    public function setNameAttribute(string $name)
    {
        $this->attributes['name'] = $name;
        
        if (!$this->alias) {
            $slug = Str::slug($name);
            if (Role::whereAlias($slug)->count() > 0) {
                $slug .= '_' . random_int(100000, 999999);
            }
            $this->attributes['alias'] = $slug;
        }
    }
    
    /**
     * Get users list to show
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    static function getList()
    {
        return Role::whereHidden(false)->paginate(config('db.admins.roles-per-page', 10));
    }
    
    /**
     * Link role and admin
     *
     * @param  Admin|int $admin
     * @return AdminRole|Model
     */
    public function linkToAdmin($admin)
    {
        if (!($admin instanceof Admin)) {
            $admin = Admin::findOrFail($admin);
        }
        return AdminRole::create(
            [
                'admin_id' => $admin->id,
                'role_id' => $this->id,
            ]
        );
    }
    
    /**
     * Update information about role
     *
     * @param  array $attributes
     * @return bool
     */
    public function updateInformation(array $attributes)
    {
        // Delete old rules
        $this->rules->each(
            function (RoleRule $rule) {
                $rule->delete();
            }
        );
        // Add new rules
        foreach (CustomRoles::get() as $moduleName => $scope) {
            $input = array_get($attributes, $moduleName);
            if (!$input) {
                continue;
            }
            RoleRule::link($this->id, $moduleName, $input);
        }
        // Update information
        $this->fill($attributes);
        return $this->save();
    }
    
    /**
     * Create new row and link rules to it
     *
     * @param  array $attributes
     * @return Role
     */
    public static function insertInformation(array $attributes)
    {
        $role = new Role();
        $role->fill($attributes);
        $role->save();
        
        // Add new rules
        foreach (CustomRoles::get() as $moduleName => $scope) {
            $input = array_get($attributes, $moduleName);
            if (!$input) {
                continue;
            }
            RoleRule::link($role->id, $moduleName, $input);
        }
        
        return $role;
    }
    
    /**
     * Could admin do something
     *
     * @param  $scope
     * @return bool
     */
    public function can($scope)
    {
        list($module, $scope) = explode('.', $scope);
        
        foreach ($this->rules as $rule) {
            if ($rule->module !== $module) {
                continue;
            }
            if (array_key_exists($scope, $rule->attributes) && $rule->{$scope} === true) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * List of roles for selects or any other dictionary data type elements
     *
     * @return array
     */
    public static function dictionary()
    {
        return Role::whereHidden(false)->get()->mapWithKeys(
            function (Role $role) {
                return [$role->id => $role->name];
            }
        )->toArray();
    }
    
    /**
     * Get all available roles to choose by administrator
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public static function available()
    {
        return Role::whereHidden(false)->get();
    }
    
    /**
     * Get ids of superadmins
     *
     * @return array
     */
    public static function getSuperadminsIds()
    {
        $superadmins = [];
        Role::whereAlias(Role::SUPERADMIN)->each(
            function (Role $role) use (&$superadmins) {
                $role->admins->each(
                    function (Admin $admin) use (&$superadmins) {
                        $superadmins[] = $admin->id;
                    }
                );
            }
        );
        return $superadmins;
    }
    
}
