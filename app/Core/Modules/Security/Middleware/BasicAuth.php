<?php

namespace App\Core\Modules\Security\Middleware;

use Closure, Response, Route;

/**
 * Class BasicAuth
 *
 * @package App\Core\Modules\Security\Middleware
 */
class BasicAuth
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
        if (!config('db.basic-auth.auth') || !config('db.basic-auth.username') || !config('db.basic-auth.password')) {
            return $next($request);
        }
    
        if (Route::currentRouteNamed('site.demo') || Route::currentRouteNamed('admin.demo') || session('demo') === true) {
        } elseif (
            $request->getUser() != config('db.basic-auth.username') ||
            $request->getPassword() != config('db.basic-auth.password')
        ) {
            return Response::make('Invalid credentials.', 401, ['WWW-Authenticate' => 'Basic']);
        }
        
        return $next($request);
    }
}
