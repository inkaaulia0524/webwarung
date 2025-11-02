<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profil admin.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update data profil admin.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Update nama & email
        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Jika password diisi
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return Redirect::back()->with('status', 'Profil admin berhasil diperbarui!');
    }
}
