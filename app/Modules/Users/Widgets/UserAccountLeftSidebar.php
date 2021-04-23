<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;
use CustomSiteMenu;

/**
 * Class UserAccountLeftSidebar
 *
 * @package App\Modules\Users\Widgets
 */
class UserAccountLeftSidebar implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('users::site.widgets.sidebar.sidebar', [
            'menu' => CustomSiteMenu::get('account-left'),
        ]);
    }
    
}
