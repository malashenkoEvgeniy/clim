<?php

namespace App\Widgets\Admin;

use App\Components\Widget\AbstractWidget;

class Footer implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('admin.widgets.footer');
    }
}
