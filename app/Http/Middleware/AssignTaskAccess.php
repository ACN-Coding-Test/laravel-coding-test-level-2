<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Traits\ResponseTrait;
class AssignTaskAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role_id != Role::PRODUCT_OWNER && $request->user_id == null || auth()->user()->role_id == Role::PRODUCT_OWNER) {
            return $next($request);
        }
        return ResponseTrait::sendResponse(null,0,'You dont have access',400);
    }
}
