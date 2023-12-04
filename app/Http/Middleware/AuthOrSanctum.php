<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthOrSanctum
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
        if (auth()->check() || $request->user()) {
            // User is authenticated through session or token.
            return $next($request);
        }
    
        return response('Unauthorized.', 401);
    }
}
