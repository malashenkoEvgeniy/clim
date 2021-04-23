<?php

namespace App\Middleware;

use Closure, Auth;

/**
 * Class ActiveUser
 *
 * @package App\Middleware
 */
class ActiveUser
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
        if (Auth::check() && Auth::user()->active === false) {
            Auth::logout();
            $routeName = config('app.place') === 'admin' ? 'admin.login' : 'site.login';
            return redirect()->route($routeName);
        }
        return $next($request);
    }
}
