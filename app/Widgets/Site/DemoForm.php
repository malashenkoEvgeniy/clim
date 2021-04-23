<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;

/**
 * Class DemoForm
 *
 * @package App\Widgets\Site
 */
class DemoForm implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (isDemo() === false) {
            return null;
        }
        return view('site.demo');
    }
    
}
