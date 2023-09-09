<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateRoutes extends Authenticate
{
    /**
     * Handle access to a route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::guard()->check()) {
            return response()->json(['data' => ['msg' => 'Você precisa estar logado para realizar essa ação.']], 401);
        }

        return $next($request);
    }
}
