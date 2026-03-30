<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si no está logueado → fuera
        if (!auth()->check()) {
            abort(403);
        }

        // Si su rol NO está en los permitidos → fuera
        if (!in_array(auth()->user()->rol, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
