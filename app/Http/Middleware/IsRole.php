<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if (auth()->user()->role != strtoupper($role)) {
            abort(403);
        }
        return $next($request);
    }
}
