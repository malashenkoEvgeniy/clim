<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\Users\Models\User;
use App\Modules\Users\Models\UserNetwork;
use Auth;
use Illuminate\Support\Collection;

class Socials implements AbstractWidget
{

    protected $registration;

    public function __construct(bool $registration = false)
    {
        $this->registration = $registration;
    }

    public function render()
    {
        $networks = new Collection();
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            if ($user->networks) {
                $user->networks->each(function (UserNetwork $network) use ($networks) {
                    $networks->put($network->network, $network);
                });
            }
        }
        $checkSocials = User::getSettingsForSocialsLogin();

        if (empty($checkSocials)) {
            return null;
        }

        return view('users::site.widgets.socials', [
            'route' => Auth::guest() ?
                config('users.social-network-route') :
                config('users.link-social-network-route'),
            'networks' => $networks,
            'checkSocials' => $checkSocials,
            'fields' => Auth::guest() ?
                config('users.fields.login') :
                config('users.fields.link'),
            'hidden' => Auth::guest() ?
                config('users.hidden-fields.login') :
                config('users.hidden-fields.link'),
        ]);
    }

}
