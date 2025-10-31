<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null)
    {
        if ($role === null) {
            return $next($request);
        }

        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        // Prefer a hasRole method if available on the User model
        if (method_exists($user, 'hasRole')) {
            if (! $user->hasRole($role)) {
                abort(403);
            }

            return $next($request);
        }

        // Fallback to a simple role property check
        if (isset($user->role)) {
            if ($user->role != $role) {
                abort(403);
            }

            return $next($request);
        }

        // Unable to determine role, deny access
        abort(403);
    }
}