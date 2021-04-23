<?php

namespace App\Modules\SiteMenu\Widgets;

use App\Components\Widget\AbstractWidget;
use CustomSiteMenu;

class HeaderMenu implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('site_menu::site.header-over.header-over', [
            'menu' => CustomSiteMenu::get('header'),
        ]);
    }
    
}
