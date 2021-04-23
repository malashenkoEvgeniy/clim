<?php

namespace App\Core\Modules\Administrators\Controllers\Admin;

use App\Core\Modules\Administrators\Models\Admin;
use App\Core\Modules\Administrators\Requests\ChangeAvatarRequest;
use App\Core\Modules\Administrators\Requests\ChangePasswordRequest;
use App\Core\Modules\Administrators\Requests\ChangeProfileRequest;
use App\Core\Modules\Administrators\Widgets\AccountMenu;
use Auth, Widget;
use App\Core\AdminController;

/**
 * Class UsersController
 * Users control
 *
 * @package App\Modules\Users\Controllers\Admin
 */
class AccountController extends AdminController
{
    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        // Register left menu widget
        Widget::register(AccountMenu::class, 'account-menu', 'inside-content-top');
    }
    
    /**
     * Logged administrator account page
     */
    public function profile()
    {
        // Script validation
        $this->initValidation((new ChangeProfileRequest())->rules());
        // Show page
        return view(
            'admins::account.profile', [
                'admin' => Auth::user(),
            ]
        );
    }
    
    /**
     * Update admins personal information
     *
     * @param  ChangeProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function update(ChangeProfileRequest $request)
    {
        // Save data
        Auth::user()->update($request->only('first_name', 'email'));
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Edit user's password page
     */
    public function password()
    {
        // Script validation
        $this->initValidation((new ChangePasswordRequest())->rules());
        // Show page
        return view('admins::account.password');
    }
    
    /**
     * Save new password
     *
     * @param  ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        /** @var Admin $admin */
        $admin = Auth::user();
        // Save data
        $admin->updatePassword($request->input('new_password'));
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Display avatar uploading form
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avatar()
    {
        /** @var Admin $admin */
        $admin = Auth::user();
        // Script validation
        $this->initValidation((new ChangeAvatarRequest())->rules());
        // Show page
        return view(
            'admins::account.avatar', [
                'admin' => $admin,
            ]
        );
    }
    
    /**
     * Store new avatar
     *
     * @param  ChangeAvatarRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     * @throws \Throwable
     */
    public function updateAvatar(ChangeAvatarRequest $request)
    {
        /** @var Admin $admin */
        $admin = Auth::user();
        // Upload image
        $admin->uploadImage();
        // Save new filename to database
        $admin->saveOrFail();
        // Do something
        return $this->afterUpdate();
    }
    
    /**
     * Delete admins avatar
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\WrongParametersException
     */
    public function deleteAvatar()
    {
        /** @var Admin $admin */
        $admin = Auth::user();
        // Delete image
        $admin->deleteImagesIfExist();
        // Do something
        return $this->afterDeletingImage();
    }
    
}
