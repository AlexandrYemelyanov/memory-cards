<?php

namespace App\Middleware;

use App\Helpers\AppLangHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        AppLangHelper::setLocale($request);

        return $next($request);
    }
}
