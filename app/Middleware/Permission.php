<?php

namespace App\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {
        if ($module === 'superadmin') {
            if (Auth::guest() || Auth::user()->is_super_admin === false) {
                abort(403, 'No access');
            }
        } elseif (Auth::user() && \CustomRoles::can($module, $request->route()->getActionMethod()) === false) {
            abort(403, 'No access');
        }
        // Next action
        return $next($request);
    }
}
