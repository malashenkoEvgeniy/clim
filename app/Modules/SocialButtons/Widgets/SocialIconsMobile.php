<?php

namespace App\Modules\SocialButtons\Widgets;

use App\Components\Widget\AbstractWidget;

class SocialIconsMobile implements AbstractWidget
{

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        $icons = [];
        foreach (config('db.social') ?? [] as $key => $link) {
            if ($link) {
                $icons[$key] = $link;
            }
        }
        return [
            'icons' => $icons,
            'labels' => config('social_buttons.site.icon-labels'),
        ];
    }

}
