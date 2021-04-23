<?php

namespace App\Widgets\Site;

use App\Components\Widget\AbstractWidget;
use Illuminate\Support\Str;

/**
 * Class LogoMobile
 *
 * @package App\Widgets\Site
 */
class LogoMobile implements AbstractWidget
{
    
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function render()
    {
        if ((bool)config('db.logo.use_image_mobile')) {
            $pathToLogo = 'app/public/' . config('app.logo-mobile.path') . '/' . config('app.logo-mobile.filename');
            $pathToLogo = preg_replace('/\/{2,}/', '/', $pathToLogo);
            $pathToLogo = storage_path($pathToLogo);
            if (is_file($pathToLogo)) {
                return view('site._widgets.elements.logo.logo', [
                    'mod_classes' => 'logo--mobile',
                    'logo' => url(config('app.logo-mobile.urlPath') . '/' . config('app.logo-mobile.filename')) . '?v=' . filemtime($pathToLogo),
                ]);
            }
        }
        return view('site._widgets.elements.logo.logo-text', [
            'mod_classes' => 'logo--mobile _color-white',
            'text' => config('db.logo.name_mobile') ?: Str::limit(env('APP_NAME'), 1, ''),
        ]);
    }
    
}
