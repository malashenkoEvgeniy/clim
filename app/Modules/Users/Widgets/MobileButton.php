<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;
use Auth;

class MobileButton implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (Auth::guest()) {
            return view('users::site.widgets.mobile-button.unauthorized');
        }
        return view('users::site.widgets.mobile-button.authorized');
    }
    
}
