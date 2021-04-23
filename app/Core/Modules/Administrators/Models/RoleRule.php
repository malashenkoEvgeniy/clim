<?php

namespace App\Core\Modules\Administrators\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Modules\Administrators\Models\RoleRule
 *
 * @property int $id
 * @property int|null $role_id
 * @property string $module Current module namespace
 * @property bool $index List pages
 * @property bool $view View page if exists
 * @property bool $store Create new / Restore row
 * @property bool $update Update information (sortable, status, edit page etc.)
 * @property bool $delete Delete row
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Core\Modules\Administrators\Models\Role|null $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\RoleRule whereView($value)
 * @mixin \Eloquent
 */
class RoleRule extends Model
{
    
    const INDEX = 'index';
    
    const VIEW = 'view';
    
    const STORE = 'store';
    
    const UPDATE = 'update';
    
    const DELETE = 'delete';
    
    /**
     * Current model table
     *
     * @var string
     */
    protected $table = 'roles_rules';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'module', 'index', 'view', 'store', 'update', 'delete'];
    
    /**
     * Fields we will not show after toArray() method
     *
     * @var array
     */
    protected $hidden = ['role_id', 'module', 'created_at', 'updated_at', 'id'];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'index' => 'boolean',
        'view' => 'boolean',
        'store' => 'boolean',
        'update' => 'boolean',
        'delete' => 'boolean',
    ];
    
    /**
     * Role for current rule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    
    /**
     * Get rules list
     *
     * @return \Illuminate\Support\Collection
     */
    static function getList()
    {
        return RoleRule::orderBy('module')->get();
    }
    
    /**
     * Create new role and link it to admin
     *
     * @param  int $roleId
     * @param  string $moduleName
     * @param  array $scope
     * @return bool
     */
    public static function link(int $roleId, string $moduleName, array $scope)
    {
        $rule = new RoleRule();
        $rule->role_id = $roleId;
        $rule->module = $moduleName;
        $rule->fill($scope);
        return $rule->save();
    }
    
}
