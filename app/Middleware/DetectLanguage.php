<?php

namespace App\Middleware;

use Closure, Config, App;
use Illuminate\Support\Facades\Auth;

class DetectLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Detect default language
        $default = config('app.locale');
        foreach (config('langs.list-for-admin', []) as $languageAlias => $language) {
            if ($language['default']) {
                $default = $languageAlias;
                break;
            }
        }
        // Set new locale for admin panel
        App::setLocale(Auth::user()->language ?? $default);
        Config::set('app.locale', Auth::user()->language ?? $default);
        // Next action
        return $next($request);
    }
}
