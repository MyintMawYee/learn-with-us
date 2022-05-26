<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('api')->user() && Auth::guard('api')->user()->type == 1) {
            return $next($request);
        }
        return response()->json([
            "result" => 0,
            "message" => "You have no permission for this route."
        ]);
    }
}
