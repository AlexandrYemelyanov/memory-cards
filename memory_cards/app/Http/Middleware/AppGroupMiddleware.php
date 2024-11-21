<?php

namespace App\Http\Middleware;

use App\Http\Helpers\GroupsHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AppGroupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post')) {
            if ($request->has('group_app')) {
                $group_id = (int) $request->post('group_app');
                GroupsHelper::setCurrentGroup($group_id);
            }
            if ($request->has('group_qty')) {
                $group_id = (int) $request->post('group_qty');
                GroupsHelper::updateQty($group_id);
            }
        }

        return $next($request);
    }
}
