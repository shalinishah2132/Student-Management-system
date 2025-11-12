<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class TokenMiddleware
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
    $validToken = '235da65e7efe666dbc2c520121bd9aa881fb841f5f51c83bb6b16678123123df';

    $Token = $request->header('Authorization') ?? $request->query('token');
   
   if ($Token !== 'Bearer ' . $validToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
}

}
