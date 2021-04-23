<?php

namespace App\Modules\Users\Controllers\Admin;

use App\Core\ObjectValues\RouteObjectValue;
use App\Modules\users\Filters\UsersFilter;
use App\Modules\Users\Forms\AdminUserForm;
use App\Modules\Users\Requests\AdminUserRequest;
use App\Core\AdminController;
use App\Modules\Users\Models\User;
use Seo;

/**
 * Class UsersController
 * Users control
 *
 * @package App\Modules\Users\Controllers\Admin
 */
class UsersController extends AdminController
{
    
    /**
     * Breadcrumb for all pages
     *
     * UsersController constructor.
     */
    public function __construct()
    {
        Seo::breadcrumbs()->add('users::seo.index', RouteObjectValue::make('admin.users.index'));
    }
    
    
    /**
     * Register widgets with buttons
     */
    private function registerButtons()
    {
        $this->addListButton('admin.users.index');
        $this->addDeletedListButton('admin.users.deleted');
        $this->addCreateButton('admin.users.create');
    }
    
    /**
     * Users list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function index()
    {
        Seo::meta()->setH1('users::seo.index');
        // Register buttons
        $this->registerButtons();
        // Show page
        return view('users::admin.users.index', [
            'users' => User::forList(),
            'filter' => UsersFilter::showFilter(),
        ]);
    }
    
    /**
     * Deleted users list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleted()
    {
        Seo::meta()->setH1('users::seo.deleted');
        // Add breadcrumbs
        Seo::breadcrumbs()->add('users::seo.deleted', RouteObjectValue::make('admin.users.deleted'));
        // Register buttons
        $this->registerButtons();
        // Show page
        return view(
            'users::admin.users.index', [
                'users' => User::trashedList(),
                'filter' => UsersFilter::showFilter(),
            ]
        );
    }
    
    /**
     * Edit user page
     *
     * @param  User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function edit(User $user)
    {
        Seo::meta()->setH1('users::seo.edit');
        // Add breadcrumbs
        Seo::breadcrumbs()->add('users::seo.edit');
        // Script validation
        $this->initValidation((new AdminUserRequest())->rules($user->id));
        // Show page
        return view('users::admin.users.update', ['form' => AdminUserForm::make($user)]);
    }
    
    /**
     * Update user data
     *
     * @param  AdminUserRequest $request
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function update(AdminUserRequest $request, User $user)
    {
        // Save new data
        $user->updateInformation($request->all());
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Create user page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\WrongParametersException
     */
    public function create()
    {
        Seo::meta()->setH1('users::seo.create');
        // Add breadcrumbs
        Seo::breadcrumbs()->add('users::seo.create');
        // Script validation
        $this->initValidation((new AdminUserRequest)->rules());
        // Show page
        return view('users::admin.users.create', ['form' => AdminUserForm::make()]);
    }
    
    /**
     * Create new user
     *
     * @param  AdminUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function store(AdminUserRequest $request)
    {
        // Register user
        $user = User::register($request->all());
        // Do something
        return $this->afterStore(['id' => $user->id]);
    }
    
    /**
     * Mark user as deleted
     *
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        // Delete user
        $user->delete();
        // Do something
        return $this->afterDestroy();
    }
    
    /**
     * Restore deleted user
     *
     * @param  $userId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function restore($userId)
    {
        // Get trashed user
        $user = User::withTrashed()->find($userId);
        // Restore
        $user->restore();
        // Do something
        return $this->afterRestore();
    }
    
}
