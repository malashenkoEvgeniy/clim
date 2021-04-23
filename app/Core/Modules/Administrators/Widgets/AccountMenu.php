<?php

namespace App\Core\Modules\Administrators\Widgets;

use App\Components\Widget\AbstractWidget;
use Auth, CustomMenu;

class AccountMenu implements AbstractWidget
{
    
    public function render()
    {
        return view(
            'admins::widgets.account-menu', [
                'menu' => CustomMenu::get('admin-menu')->group()->getKids(),
                'admin' => Auth::user(),
            ]
        );
    }
    
}
