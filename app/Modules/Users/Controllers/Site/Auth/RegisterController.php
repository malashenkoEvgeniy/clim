<?php

namespace App\Modules\Users\Controllers\Site\Auth;

use App\Core\AjaxTrait;
use App\Core\SiteController;
use App\Modules\Users\Models\User;
use App\Modules\Users\Requests\Site\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends SiteController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    
    use RegistersUsers, AjaxTrait;
    
    /**
     * Where to redirect users after registration.
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
        $this->redirectTo = route('site.account');
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $this->sameMeta('users::site.seo.registration');
        $this->breadcrumb('users::site.seo.registration');
        return view('users::site.register');
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, (new Registration())->rules());
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Modules\Users\Models\User
     */
    protected function create(array $data)
    {
        $user = User::whereEmail($data['email'])->onlyTrashed()->first();
        if ($user && $user->exists) {
            $user->restore();
            $user->first_name = $data['name'] ?? $user->first_name;
            $user->email = $data['email'];
            $user->phone = $data['phone'] ?? $user->phone;
            $user->password = $data['password'];
            return $user;
        }
        return User::create([
            'first_name' => $data['name'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
        ]);
    }
    
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        session()->flash('message', trans('users::auth.registered-successfully'));
        if ($request->expectsJson()) {
            return $this->successJsonAnswer([
                'redirect' => $this->redirectTo,
            ]);
        }
    }
}
