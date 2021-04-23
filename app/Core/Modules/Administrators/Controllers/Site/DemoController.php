<?php

namespace App\Core\Modules\Administrators\Controllers\Site;

use App\Core\AdminController;
use App\Core\Modules\Administrators\Models\Admin;
use App\Core\Modules\Administrators\Models\AdminRole;
use App\Core\Modules\Administrators\Models\Role;
use Auth;

/**
 * Class DemoController
 *
 * @package App\Core\Modules\Administrators\Controllers\Site
 */
class DemoController extends AdminController
{
    
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $adminUrl = '/' . config('app.admin_panel_prefix');
        if (!isDemo()) {
            return redirect()->to($adminUrl);
        }
        if (Auth::guard('admin')->check()) {
            return redirect()->to($adminUrl);
        }
        $user = new Admin();
        $user->first_name = 'Demo admin';
        $user->email = 'demo' . time() . rand(1000, 9999) . '@gmail.com';
        $user->password = 'demo';
        $user->remember_token = str_random(10);
        $user->save();
        
        $role = new AdminRole();
        $role->admin_id = $user->id;
        $role->role_id = Role::whereAlias(Role::SUPERADMIN)->firstOrFail()->id;
        $role->save();
        
        Auth::guard('admin')->login($user);
        return redirect()->to($adminUrl);
    }
    
}
