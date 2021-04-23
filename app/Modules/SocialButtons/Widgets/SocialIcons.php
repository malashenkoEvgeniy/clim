<?php

namespace App\Modules\SocialButtons\Widgets;

use App\Components\Widget\AbstractWidget;

class SocialIcons implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('social_buttons::site.social-icons', [
            'icons' => config('db.social') ?? [],
            'labels' => config('social_buttons.site.icon-labels'),
        ]);
    }

}
