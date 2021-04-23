<?php

namespace App\Core\Modules\Administrators\Widgets;

use App\Components\Widget\AbstractWidget;
use Auth, CustomMenu;

/**
 * Class TopUserMenu
 * Menu on the top of the page in admin panel
 *
 * @package App\Modules\Auth\Widgets\Admin
 */
class AuthMenu implements AbstractWidget
{
    
    public function render()
    {
        return view(
            'admins::widgets.auth-menu', [
                'menu' => CustomMenu::get('admin-menu')->group()->getKids(),
                'admin' => Auth::user(),
            ]
        );
    }
    
}
