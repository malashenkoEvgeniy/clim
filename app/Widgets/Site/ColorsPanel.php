<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use Auth;

/**
 * Class ColorPanel
 *
 * @package App\Widgets\Site
 */
class ColorsPanel implements AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if (Auth::guard('admin')->guest()) {
            return null;
        }
        return view('site.administrator.color-panel', [
            'colors' => [
                [
                    'label' => 'main',
                    'name' => trans('settings::general.colors.main'),
                    'value' => config('db.colors.main') ?: '#60bc4f',
                ],
                [
                    'label' => 'main-lighten',
                    'name' => trans('settings::general.colors.main-lighten'),
                    'value' => config('db.colors.main-lighten') ?: '#68ca56',
                ],
                [
                    'label' => 'main-darken',
                    'name' => trans('settings::general.colors.main-darken'),
                    'value' => config('db.colors.main-darken') ?: '#59ad49',
                ],
                [
                    'label' => 'secondary',
                    'name' => trans('settings::general.colors.secondary'),
                    'value' => config('db.colors.secondary') ?: '#f7931d',
                ],
                [
                    'label' => 'secondary-lighten',
                    'name' => trans('settings::general.colors.secondary-lighten'),
                    'value' => config('db.colors.secondary-lighten') ?: '#f7b21d',
                ],
                [
                    'label' => 'secondary-darken',
                    'name' => trans('settings::general.colors.secondary-darken'),
                    'value' => config('db.colors.secondary-darken') ?: '#e84d1a',
                ],
            ],
        ]);
    }
    
}
