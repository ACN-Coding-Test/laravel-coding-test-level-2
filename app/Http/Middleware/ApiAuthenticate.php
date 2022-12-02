<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Bouncer;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class ApiAuthenticate 
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
        $check_auth = Auth::check();
        if ($check_auth) {
            Auth::user()->isAn('Admin');
            if (Auth::user()->isAn('Admin')){
                return $next($request);
            }
        } 
        return response('Unauthorized.', 401);

    }
}
