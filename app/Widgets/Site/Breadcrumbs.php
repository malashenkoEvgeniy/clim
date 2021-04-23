<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use Seo;

class Breadcrumbs implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (Seo::breadcrumbs()->count() < 2) {
            return null;
        }
        return view('site-custom.breadcrumbs');
    }
    
}
