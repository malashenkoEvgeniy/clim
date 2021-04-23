<?php

namespace App\Modules\Consultations\Widgets;

use App\Components\Widget\AbstractWidget;

/**
 * Class Button
 *
 * @package App\Modules\Callback\Widgets
 */
class Button implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('consultations::site.button');
    }
    
}
