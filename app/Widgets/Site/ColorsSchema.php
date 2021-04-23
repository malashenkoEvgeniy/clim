<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;

/**
 * Class ColorsSchema
 *
 * @package App\Widgets\Site
 */
class ColorsSchema implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        return view('site._widgets.variables', [
            'main' => config('db.colors.main') ?: '#60bc4f',
            'mainLighten' => config('db.colors.main-lighten') ?: '#68ca56',
            'mainDarken' => config('db.colors.main-darken') ?: '#59ad49',
            'secondary' => config('db.colors.secondary') ?: '#f7931d',
            'secondaryLighten' => config('db.colors.secondary-lighten') ?: '#f7b21d',
            'secondaryDarken' => config('db.colors.secondary-darken') ?: '#e84d1a',
        ]);
    }
    
}
