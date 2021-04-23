<?php

namespace App\Core\Modules\Administrators\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Modules\Administrators\Models\AdminRole
 *
 * @property int $id
 * @property int|null $role_id
 * @property int|null $admin_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\AdminRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\AdminRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\AdminRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\AdminRole whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\AdminRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\AdminRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\AdminRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Modules\Administrators\Models\AdminRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdminRole extends Model
{
    
    /**
     * Current model table
     *
     * @var string
     */
    protected $table = 'admins_roles';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_id', 'admin_id'];
    
    /**
     * Delete all roles links for admin
     *
     * @param  int $adminId
     * @return bool|mixed|null
     * @throws \Exception
     */
    static function deleteFor(int $adminId)
    {
        return AdminRole::whereAdminId($adminId)->delete();
    }
    
    /**
     * Link admin and role
     *
     * @param  int $adminId
     * @param  int $roleId
     * @return AdminRole
     */
    static function link(int $adminId, int $roleId)
    {
        $link = new AdminRole();
        $link->admin_id = $adminId;
        $link->role_id = $roleId;
        $link->save();
        
        return $link;
    }
    
}
