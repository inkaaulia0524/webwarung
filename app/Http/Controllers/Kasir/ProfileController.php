<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Page Edit Profil Kasir
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        return view('kasir.profile.edit', compact('user'));
    }

    /**
     * Update Profil Kasir
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255'],
            'password' => ['nullable','confirmed', Rules\Password::defaults()],
        ]);

        // update nama + email
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // update password hanya jika diisi
        if(!empty($validated['password'])){
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
        }

        return Redirect::back()->with('success', 'Profil kasir berhasil diperbarui!');
    }
}
