<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
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
        $currentUser = JWTAuth::authenticate($request->token);
        \Log::info($currentUser->role_id);
        if ($currentUser->role_id == 3) {
            return $next($request);
        }
        return response()->json(["status"=>Response::HTTP_UNAUTHORIZED,'message' => 'Unauthorized User'],Response::HTTP_UNAUTHORIZED);
    }
}
