<?php

namespace App\Modules\SiteMenu\Widgets;

use App\Components\Widget\AbstractWidget;
use CustomSiteMenu;

/**
 * Class FooterMenu
 * @package App\Modules\SiteMenu\Widgets
 */
class FooterMenu implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (CustomSiteMenu::get('footer')->hasKids() === false) {
            return null;
        }
        return view('site_menu::site.footer-menu', [
            'menu' => CustomSiteMenu::get('footer'),
        ]);
    }
    
}
