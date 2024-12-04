<?php

namespace App\Middleware;

use App\Helpers\GroupsHelper;
use Closure;
use Illuminate\Http\Request;
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
