<?php

namespace App\Core\Modules\Administrators\Controllers\Admin;

use App\Core\Modules\Administrators\Forms\RolesForm;
use App\Core\Modules\Administrators\Models\Role;
use App\Core\AdminController;
use App\Core\Modules\Administrators\Requests\RoleRequest;
use App\Core\ObjectValues\RouteObjectValue;
use Seo;

/**
 * Class RolesController
 *
 * @package App\Core\Modules\Administrators\Controllers\Admin
 */
class RolesController extends AdminController
{
    
    /**
     * RolesController constructor.
     */
    public function __construct()
    {
        Seo::breadcrumbs()->add('admins::seo.roles.index', RouteObjectValue::make('admin.roles.index'));
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        $this->addCreateButton('admin.roles.create');
    }
    
    /**
     * Roles list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Seo::meta()->setH1('admins::seo.roles.index');
        // Register buttons
        $this->registerButtons();
        // Show page
        return view(
            'admins::roles.index', [
                'roles' => Role::getList(),
            ]
        );
    }
    
    /**
     * Edit role page
     *
     * @param  Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Role $role)
    {
        // Check if role is not superadmin
        abort_if($role->alias === Role::SUPERADMIN, 404);
        // Meta tags
        Seo::meta()->setH1('admins::seo.roles.edit');
        // Add breadcrumbs
        Seo::breadcrumbs()->add('admins::seo.roles.edit');
        // Script validation
        $this->initValidation((new RoleRequest)->rules());
        // Show page
        return view(
            'admins::roles.update', [
                'form' => RolesForm::make($role),
            ]
        );
    }
    
    /**
     * Update role data
     *
     * @param  RoleRequest $request
     * @param  Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function update(RoleRequest $request, Role $role)
    {
        // Check if role is not superadmin
        abort_if($role->alias === Role::SUPERADMIN, 404);
        // Save new data
        $role->updateInformation($request->all());
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Create role page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        Seo::meta()->setH1('admins::seo.roles.create');
        // Add breadcrumbs
        Seo::breadcrumbs()->add('admins::seo.roles.create');
        // Script validation
        $this->initValidation((new RoleRequest)->rules());
        // Show page
        return view('admins::roles.create', ['form' => RolesForm::make()]);
    }
    
    /**
     * Create new role
     *
     * @param  RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function store(RoleRequest $request)
    {
        // Create role
        $role = Role::insertInformation($request->all());
        // Do something
        return $this->afterStore(['id' => $role->id]);
    }
    
    /**
     * Delete role
     *
     * @param  Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Role $role)
    {
        // Check if role is not superadmin
        abort_if($role->alias === Role::SUPERADMIN, 404);
        // Delete role
        $role->delete();
        // Do something
        return $this->afterDestroy();
    }
    
}
