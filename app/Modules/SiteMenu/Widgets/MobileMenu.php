<?php

namespace App\Modules\SiteMenu\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\SiteMenu\Models\SiteMenu;
use CustomSiteMenu;

class MobileMenu implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('site_menu::site.mobile-menu', [
            'menu' => CustomSiteMenu::get(SiteMenu::PLACE_MOBILE),
        ]);
    }
    
}
