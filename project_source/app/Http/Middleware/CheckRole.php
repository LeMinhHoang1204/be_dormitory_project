<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Kiểm tra role
        if (auth()->check() && auth()->user()->role === $role) {
            return $next($request);
        }

        return abort(403, 'Unauthorized');
    }
}
