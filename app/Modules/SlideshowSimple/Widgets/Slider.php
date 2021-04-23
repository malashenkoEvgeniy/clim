<?php

namespace App\Modules\SlideshowSimple\Widgets;

use App\Components\Widget\AbstractWidget;
use App\Modules\SlideshowSimple\Models\SlideshowSimple;

class Slider implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $slides = SlideshowSimple::getAllActive();
        return view('slideshow_simple::site.widget', [
            'slides' => $slides,
        ]);
    }
    
}
