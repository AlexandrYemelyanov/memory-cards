<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            Cookie::queue('lang', $locale, 518400);
        } else {
            $locale = $request->cookie('lang', config('app.locale'));
        }
        App::setLocale($locale);

        return $next($request);
    }
}
