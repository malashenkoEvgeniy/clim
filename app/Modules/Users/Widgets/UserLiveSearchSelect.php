<?php

namespace App\Modules\Users\Widgets;

use App\Components\Widget\AbstractWidget;

class UserLiveSearchSelect implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('users::admin.live-search-select');
    }
    
}
