<?php

namespace App\Modules\Users\Controllers\Site\Auth;

use App\Core\AjaxTrait;
use App\Modules\Users\Components\SocialAdapter;
use App\Modules\Users\Controllers\Site\SocialsController;
use App\Modules\Users\Models\UserNetwork;
use Auth;
use Socialite;

use Illuminate\Http\Request;
use Event;
use App\Core\SiteController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

/**
 * Class IndexController
 * This is authentication mechanism for simple users
 *
 * @package App\Modules\Auth\Controllers\Frontend
 */
class LoginController extends SiteController
{
    use AuthenticatesUsers, AjaxTrait;

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
        $this->redirectTo = route('site.account');
    }

    /**
     * Show login page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->sameMeta('users::site.seo.login');
        $this->breadcrumb('users::site.seo.login');
        return view('users::site.login');
    }

    /**
     * @param null $alias
     * @return bool|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function socialsLogin($alias = null)
    {
        if (!$alias) {
            return false;
        }
        $provider = config('services.socials-login-tools');
        if (
            isset($provider) &&
            $provider === 'hybridauth'
        ) {
            $adapter = SocialAdapter::getAdapter($alias);
            if ($adapter->authenticate()) {
                $userData = $adapter->getUserProfile();
                $socialController = new SocialsController();
                $profile = $socialController->getCorrectDataOfProfile($userData, $alias);
                if (Auth::id()) {
                    $socialController->link($profile);
                } else {
                    $network = UserNetwork::getByNetworkAndUid($profile['network'], $profile['uid']);
                    if (!$network || !$network->user) {
                        if ($network) {
                            $network->delete();
                        }
                        return $socialController->registration($profile);
                    }
                    Auth::login($network->user);
                    event('user.login', $network->user_id);
                }
                return redirect()
                    ->route('site.account')
                    ->with('message', trans('auth.succeed'));
            }
        } else {
            return Socialite::driver($alias)->redirect();
        }
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
        return redirect(route('site.home'));
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        Event::fire('user.login', $user->id);
        session()->flash('message', trans('auth.succeed'));
        if ($request->expectsJson()) {
            return $this->successJsonAnswer([
                'redirect' => $request->input('redirect', $this->redirectTo),
            ]);
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->expectsJson()) {
            return $this->errorJsonAnswer([
                'notyMessage' => trans('auth.failed'),
            ]);
        }
        throw ValidationException::withMessages([
            $this->username() => [trans(
                'auth.failed')],
        ]);
    }

    public function username()
    {
        return 'email';
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
