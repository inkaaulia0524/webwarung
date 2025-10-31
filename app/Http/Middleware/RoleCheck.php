<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * Contoh pakai:
     * ->middleware('RoleCheck:admin')
     * ->middleware('RoleCheck:admin,kasir')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // user login tapi role-nya tidak ada di daftar yg diizinkan
        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles, true)) {
            // opsional: logout + pesan
            Auth::logout();
            return redirect()
                ->route('login')
                ->with('status', 'Halaman ini tidak dapat diakses, silakan login kembali.');
        }

        return $next($request);
    }
}