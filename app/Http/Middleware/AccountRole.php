<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccountRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $type)
    {
        if (auth('api')->user()->role == $type) {
            return $next($request);
        }
        $response = [
            'success' => false,
            'message' => 'You don\'t have permission to access this api.',
        ];
        return response()->json($response);
    }
}
