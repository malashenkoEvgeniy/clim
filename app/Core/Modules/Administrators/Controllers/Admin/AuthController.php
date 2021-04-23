<?php

namespace App\Core\Modules\Administrators\Controllers\Admin;

use Auth;
use App\Core\AdminController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * Class IndexController
 * This is authentication mechanism for administrators
 *
 * @package App\Modules\Auth\Controllers\Backend
 */
class AuthController extends AdminController
{
    use AuthenticatesUsers;
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = route('admin.dashboard');
    }
    
    /**
     * Show log in page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admins::auth.login');
    }
    
    /**
     * Simple logout by GET request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        $this->guard()->logout();
        request()->session()->invalidate();
        return redirect(route('admin.login'));
    }
    
    /**
     * Get current guard
     *
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
    
    protected function attemptLogin(Request $request)
    {
        $request->request->add(['active' => true]);
        return $this->guard()->attempt(
            $request->only($this->username(), 'password', 'active'),
            $request->filled('remember')
        );
    }
    
}
