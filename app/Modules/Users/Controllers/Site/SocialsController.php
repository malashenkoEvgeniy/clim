<?php

namespace App\Modules\Users\Controllers\Site;

use App\Core\SiteController;
use App\Modules\Users\Components\SocialAdapter;
use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserNetwork;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth, Validator;
use Socialite;

/**
 * Class SocialsController
 *
 * @package App\Modules\Users\Controllers\Site
 */
class SocialsController extends SiteController
{
    use AuthenticatesUsers;

    /**
     * @param Request $request
     * @param null $alias
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function hub(Request $request, $alias = null)
    {
        if (!$alias) {
            return redirect()->route('site.login');
        }
        $provider = config('services.socials-login-tools');
        if (
            isset($provider) &&
            $provider === 'hybridauth'
        ) {
            $profile = $this->getProfileDataByHybrid($alias);
        } else {
            $profile = $this->getProfileDataBySociable($alias);
        }
        if (!$profile || isset($profile['uid']) === false) {
            return redirect()->route('site.login');
        }
        if (Auth::id()) {
            $this->link($profile);
        }
        $network = UserNetwork::getByNetworkAndUid($profile['network'], $profile['uid']);
        if (!$network || !$network->user) {
            if ($network) {
                $network->delete();
            }
            return $this->registration($profile);
        }
        return $this->login($network);
    }

    /**
     * @param $alias
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function getProfileDataByHybrid($alias)
    {
        $adapter = SocialAdapter::getAdapter($alias);
        try {
            $adapter->authenticate();
            $userData = $adapter->getUserProfile();
        } catch (\Exception $exception) {
            return redirect()->route('site.login')->with('message', $exception->getMessage());
        }
        return $this->getCorrectDataOfProfile($userData, $alias);
    }

    /**
     * @param $alias
     * @return array|\Illuminate\Http\RedirectResponse
     */
    public function getProfileDataBySociable($alias)
    {
        try {
            $userData = Socialite::driver($alias)->user();
        } catch (\Exception $exception) {
            return redirect()->route('site.login')->with('message', $exception->getMessage());
        }
        return $this->getCorrectDataOfProfileSociable($userData, $alias);
    }

    /**
     * @param UserNetwork $network
     * @return \Illuminate\Http\RedirectResponse
     */
    private function login(UserNetwork $network)
    {
        Auth::login($network->user);
        event('user.login', $network->user_id);
        return redirect()
            ->route('site.account')
            ->with('message', trans('auth.succeed'));
    }

    /**
     * @param array $profile
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Throwable
     */
    public function registration(array $profile)
    {
        $phone = preg_replace('/[^\+0-9]*/', '', array_get($profile, 'phone'));
        $profile['phone'] = $phone;
        if (!$profile['email']) {
            return view('users::site.fill-info', ['userData' => $profile]);
        }
        Validator::make($profile, [
            'phone' => 'nullable|string|regex:/\+380[0-9]{9}/|max:191',
            'email' => 'required|string|email|max:191|unique:users',
        ])->validate();
        $password = random_int(100000, 999999);
        $profile['password'] = $password;
        $profile['active'] = true;
        $user = User::register($profile);
        request()->merge(['password' => $password]);
        UserNetwork::link($user->id, $profile);
        Auth::login($user);
        event(new Registered($user));
        return redirect()
            ->route('site.account')
            ->with('message', trans('users::auth.registered-successfully'));
    }

    /**
     * @param $profile
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function link($profile)
    {
        if (!$profile || isset($profile['uid']) === false) {
            return redirect()->route('site.account');
        }
        $network = UserNetwork::getByNetworkAndUid($profile['network'], $profile['uid']);
        if ($network) {
            if ($network->user && $network->user_id === Auth::id()) {
                return redirect()->route('site.account');
            }
            if ($network->user) {
                $network->delete();
            }
        }
        if (!$profile['email']) {
            $profile['email'] = Auth::user()->email;
        }
        UserNetwork::link(Auth::id(), $profile);
        return redirect()->route('site.account');
    }

    /**
     * @param $data
     * @param $networkAlias
     * @return array
     */
    public function getCorrectDataOfProfile($data, $networkAlias)
    {
        $profile = [
            'uid' => $data->identifier,
            'network' => $networkAlias,
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'email' => $data->email,
            'phone' => $data->phone,
            'identity' => $data->profileURL,
        ];
        if (!$data->firstName && !$data->lastName) {
            if ($data->displayName) {
                $name = explode(' ', $data->displayName, 2);
                $profile['last_name'] = $name[0];
                $profile['first_name'] = $name[1];
            }
        }
        return $profile;
    }

    /**
     * @param $data
     * @param $networkAlias
     * @return array
     */
    public function getCorrectDataOfProfileSociable($data, $networkAlias)
    {
        $profile = [
            'uid' => $data->id,
            'network' => $networkAlias,
            'email' => $data->email,
            'phone' => $data->phone ?? null,
        ];
        if ($data->name) {
            $name = explode(' ', $data->name, 2);
            $profile['last_name'] = $name[0] ?? null;
            $profile['first_name'] = $name[1] ?? null;
        }
        switch ($networkAlias){
            case 'facebook' :
                $profile['identity'] = $data->profileUrl ?? null;
                break;
            case 'twitter' :
                $profile['identity'] = $data->nickname ? 'https://twitter.com/'.$data->nickname : null;
                break;
            case 'google' :
                $profile['identity'] = $data->user['link'] ?? null;
                break;
            case 'instagram' :
                $profile['identity'] = $data->nickname ? 'https://www.instagram.com/'.$data->nickname : null;
                break;
            default:
                $profile['identity'] = null;
        }
        return $profile;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function socialsFillInfo(Request $request)
    {
        return $this->registration($request->all());
    }

}
