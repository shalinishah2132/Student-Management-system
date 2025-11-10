<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // If user doesn't have permission
        abort(403, 'Unauthorized action.');
    }
}
