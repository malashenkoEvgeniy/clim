<?php

namespace App\Console\Commands;

use App\Core\Modules\Administrators\Models\Admin;
use App\Core\Modules\Administrators\Models\AdminRole;
use App\Core\Modules\Administrators\Models\Role;
use Illuminate\Console\Command;
use Validator;
use Illuminate\Validation\Rule;

/**
 * Class CreateSuperAdmin
 *
 * @package App\Console\Commands
 */
class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'locotrade:superadmin';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create super user';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->typeName();
        $email = $this->typeEmail();
        $password = $this->typePassword();
    
        $admin = Admin::create([
            'first_name' => $name,
            'email' => $email,
            'password' => $password,
            'remember_token' => str_random(10),
        ]);
    
        $role = new AdminRole();
        $role->admin_id = $admin->id;
        $role->role_id = Role::whereAlias(Role::SUPERADMIN)->firstOrFail()->id;
        $role->save();
        
        $this->info('Суперпользователь создан!');
    }
    
    /**
     * @return string
     */
    private function typeEmail(): string
    {
        $email = $this->ask('Укажите email суперпользователя');
        $validator = Validator::make(['email' => $email], [
            'email' => ['required', 'email', Rule::unique('admins')],
        ]);
        if ($validator->fails()) {
            $this->warn($validator->errors()->first());
            return $this->typeEmail();
        }
        return $email;
    }
    
    /**
     * @return string
     */
    private function typePassword(): string
    {
        $password = $this->ask('Укажите пароль суперпользователя');
        $validator = Validator::make(['password' => $password], [
            'password' => ['required', 'string', 'min:6'],
        ]);
        if ($validator->fails()) {
            $this->warn($validator->errors()->first());
            return $this->typePassword();
        }
        return $password;
    }
    
    /**
     * @return string
     */
    private function typeName(): string
    {
        $name = $this->ask('Укажите имя суперпользователя');
        $validator = Validator::make(['name' => $name], [
            'name' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            $this->warn($validator->errors()->first());
            return $this->typeName();
        }
        return $name;
    }
}
