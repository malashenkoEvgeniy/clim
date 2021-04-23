<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;
use Auth;

class HeaderAuthLink implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (Auth::guest()) {
            return view('users::site.widgets.header-auth-link');
        }
        return view('users::site.widgets.header-auth-link-authorized');
    }
    
}
