<?php

namespace App\Core\Modules\Administrators\Database\Seeds;

use App\Core\Modules\Administrators\Models\Admin;
use App\Core\Modules\Administrators\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'Суперадминистратор';
        $role->alias = Role::SUPERADMIN;
        $role->hidden = true;
        $role->active = true;
        $role->save();
        
        $role->linkToAdmin(Admin::oldest('id')->first()->id);
    }
}
