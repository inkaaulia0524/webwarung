<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- PERUBAHAN DIMULAI DI SINI ---
        
        // Ambil role, ubah ke huruf kecil, dan beri nilai default '' jika null
        $role = strtolower(Auth::user()->role ?? ''); 

        // Cek rolenya dan arahkan ke route yang benar
        if ($role == 'admin') {
            // Arahkan ke route yang bernama 'admin.dashboard'
            return redirect()->route('admin.dashboard'); 
        
        } elseif ($role == 'kasir') {
            // Arahkan ke route yang bernama 'kasir.dashboard'
            return redirect()->route('kasir.dashboard');
        
        } else {
            // Fallback jika rolenya tidak dikenal
            // Kita ganti redirect()->intended() menjadi redirect() polos
            // Ini akan "memaksa" browser melakukan request GET dan menghindari error 405
            return redirect(route('dashboard', absolute: false));
        }
        
        // --- PERUBAHAN SELESAI ---
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

