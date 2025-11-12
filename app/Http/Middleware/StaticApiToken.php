<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaticApiToken
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
        // Define your static token here
        $staticToken = 'my-secret-token-12345';

        // Check token from header
        $headerToken = $request->header('Authorization');

        if ($headerToken !== 'Bearer ' . $staticToken) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
