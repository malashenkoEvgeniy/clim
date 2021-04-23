<?php

namespace App\Core\Modules\Administrators\Controllers\Admin;

use App\Core\Modules\Administrators\Filters\AdminFilter;
use App\Core\Modules\Administrators\Forms\AdminForm;
use App\Core\Modules\Administrators\Models\Admin;
use App\Core\Modules\Administrators\Requests\AdminCreateRequest;
use App\Core\Modules\Administrators\Requests\AdminUpdateRequest;
use App\Core\AdminController;
use App\Core\ObjectValues\RouteObjectValue;
use Seo;

/**
 * Class AdminsController
 *
 * @package App\Modules\Users\Controllers\Admin
 */
class AdminsController extends AdminController
{
    
    /**
     * AdminsController constructor.
     */
    public function __construct()
    {
        Seo::breadcrumbs()->add('admins::seo.admins.index', RouteObjectValue::make('admin.admins.index'));
    }
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        $this->addCreateButton('admin.admins.create');
    }
    
    /**
     * Admins list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        Seo::meta()->setH1('admins::seo.admins.index');
        // Register buttons
        $this->registerButtons();
        // Show page
        return view(
            'admins::admins.index', [
                'admins' => Admin::forList(),
                'filter' => AdminFilter::showFilter(),
            ]
        );
    }
    
    /**
     * Edit admin page
     *
     * @param  Admin $admin
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(Admin $admin)
    {
        abort_unless($admin->couldBeEdited(), 404);
        // Meta tags
        Seo::meta()->setH1('admins::seo.admins.edit');
        // Add breadcrumbs
        Seo::breadcrumbs()->add('admins::seo.admins.edit');
        // Script validation
        $this->initValidation((new AdminUpdateRequest)->rules());
        // Show page
        return view('admins::admins.update', ['form' => AdminForm::make($admin)]);
    }
    
    /**
     * Update admin data
     *
     * @param  AdminUpdateRequest $request
     * @param  Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        // Save new data
        $admin->updateInformation($request->all());
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Create admin page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        Seo::meta()->setH1('admins::seo.admins.create');
        // Add breadcrumbs
        Seo::breadcrumbs()->add('admins::seo.admins.create');
        // Script validation
        $this->initValidation((new AdminCreateRequest)->rules());
        // Show page
        return view('admins::admins.create', ['form' => AdminForm::make()]);
    }
    
    /**
     * Create new admin
     *
     * @param  AdminCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function store(AdminCreateRequest $request)
    {
        // Register admin
        $admin = Admin::register($request->all());
        // Do something
        return $this->afterStore(['id' => $admin->id]);
    }
    
    /**
     * Mark admin as deleted
     *
     * @param  Admin $admin
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Admin $admin)
    {
        // Check if role is not superadmin
        abort_unless($admin->couldBeEdited(), 404);
        // Delete admin
        $admin->delete();
        // Do something
        return $this->afterDestroy();
    }
    
}
