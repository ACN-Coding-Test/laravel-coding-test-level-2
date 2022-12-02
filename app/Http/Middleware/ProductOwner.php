<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $check_auth = Auth::check();
        if ($check_auth) {
            Auth::user()->isAn('PRODUCT_OWNER');
            if (Auth::user()->isAn('PRODUCT_OWNER')){
                return $next($request);
            }
        } 
        return response('Unauthorized.', 401);
    }
}
