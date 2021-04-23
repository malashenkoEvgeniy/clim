<?php

namespace App\Modules\SeoRedirects\Middleware;

use App\Modules\SeoRedirects\Models\SeoRedirect;
use Closure, Request;

class Seo
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
        $redirect = $this->redirects();
        if ($redirect) {
            return redirect($redirect->link_to, $redirect->type);
        }
        if (preg_match('@\/page\/1$@', request()->fullUrl())) {
            $url = preg_replace('@\/page\/1$@', '', request()->fullUrl());
            return redirect($url, 301);
        }
        return $next($request);
    }

    /**
     * @return SeoRedirect|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    private function redirects()
    {
        $result = SeoRedirect::getWhereUrl(Request::getRequestUri());
        if ($result && $result->exists) {
            return $result;
        }
        return null;
    }
}
