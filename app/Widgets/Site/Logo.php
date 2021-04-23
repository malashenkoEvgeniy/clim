<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;

/**
 * Class Logo
 *
 * @package App\Widgets\Site
 */
class Logo implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if ((bool)config('db.logo.use_image')) {
            $pathToLogo = 'app/public/' . config('app.logo.path') . '/' . config('app.logo.filename');
            $pathToLogo = preg_replace('/\/{2,}/', '/', $pathToLogo);
            $pathToLogo = storage_path($pathToLogo);
            if (is_file($pathToLogo)) {
                return view('site._widgets.elements.logo.logo', [
                    'logo' => url(config('app.logo.urlPath') . '/' . config('app.logo.filename')) . '?v=' . filemtime($pathToLogo),
                ]);
            }
        }
        return view('site._widgets.elements.logo.logo-text', [
            'mod_classes' => '_color-black',
            'text' => config('db.logo.name') ?: env('APP_NAME'),
        ]);
    }
    
}
