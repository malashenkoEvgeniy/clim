<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;
use Auth;

class AreYouClientButton implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (Auth::check()) {
            return null;
        }
        return view('users::site.widgets.are-you-client');
    }
    
}
