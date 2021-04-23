<?php

namespace App\Modules\Users\Controllers\Site;

use App\Core\SiteController;
use App\Modules\Users\Models\User;
use App\Modules\Users\Requests\ChangePasswordRequest;
use App\Modules\Users\Requests\UpdateProfileRequest;
use Auth;

/**
 * Class CategoryController
 *
 * @package App\Modules\Categories\Controllers\Admin
 */
class ProfileController extends SiteController
{
    
    /**
     * Authenticated user profile
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->sameMeta('users::site.seo.my-profile');
        $this->breadcrumb('users::site.seo.my-profile');
        return view('users::site.profile-view', [
            'message' => request()->session()->get('message'),
        ]);
    }
    
    /**
     * Update current user  personal information page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        $this->sameMeta('users::site.seo.edit-profile');
        $this->breadcrumb('users::site.seo.edit-profile');
        $formId = 'profile-update-information';
        $this->initValidation((new UpdateProfileRequest)->rules(), "#$formId");
        return view('users::site.profile-edit', [
            'user' => Auth::user(),
            'message' => request()->session()->get('message'),
            'formId' => $formId,
        ]);
    }
    
    /**
     * Update current user  personal information
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        $dataToUpdate = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ];
        User::whereId(Auth::user()->id)->update($dataToUpdate);
        $request->session()->flash('message', trans('users::site.success-message'));
        return back();
    }
    
    /**
     * Change password form view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function password()
    {
        $this->sameMeta('users::site.seo.edit-password');
        $this->breadcrumb('users::site.seo.edit-password');
        $formId = 'profile-change-password';
        $this->initValidation((new ChangePasswordRequest)->rules(), "#$formId");
        return view('users::site.profile-password-change', [
            'message' => request()->session()->get('message'),
            'formId' => $formId,
        ]);
    }
    
    /**
     * Change password action
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $user->updatePassword($request->input('new_password'));
        $request->session()->flash('message', trans('users::site.success-message'));
        return back();
    }
    
}
