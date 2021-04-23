<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;
use CustomSiteMenu;

class UserAccountTopMenu implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('users::site.widgets.top-menu', [
            'menu' => CustomSiteMenu::get('account-left'),
        ]);
    }
    
}
