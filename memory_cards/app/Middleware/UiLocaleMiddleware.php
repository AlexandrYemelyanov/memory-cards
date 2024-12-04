<?php

namespace App\Middleware;

use App\Helpers\UiLangHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class UiLocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        UiLangHelper::setLocale($request);
        App::setLocale(UiLangHelper::getLocale($request));

        return $next($request);
    }
}
