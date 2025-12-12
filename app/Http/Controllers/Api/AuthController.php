<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * REGISTER (Pendaftaran Akun Baru)
     * Otomatis role = 'kasir'
     */
    public function register(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8',
        ]);

        // Jika validasi gagal, kirim error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 2. Buat User Baru (Paksa jadi Kasir)
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'kasir', // <--- ROLE DEFAULT
        ]);

        // 3. Buat Token (Tiket Masuk)
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. Kirim Respon ke Flutter
        return response()->json([
            'message'       => 'Registrasi berhasil. Anda terdaftar sebagai Kasir.',
            'data'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ]);
    }

    /**
     * LOGIN (Masuk Aplikasi)
     * Mengembalikan token dan role user
     */
    public function login(Request $request)
    {
        // 1. Cek kecocokan Email & Password
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau Password salah'
            ], 401);
        }

        // 2. Ambil data user dari database
        $user = User::where('email', $request->email)->firstOrFail();

        // 3. Buat Token Baru
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. Kirim Respon (Sertakan Role)
        return response()->json([
            'message'       => 'Login berhasil',
            'data'          => $user,
            'role'          => $user->role, // <--- PENTING: Kirim role ke Flutter
            'access_token'  => $token,
            'token_type'    => 'Bearer',
        ]);
    }

    /**
     * LOGOUT (Keluar Aplikasi)
     * Menghapus token
     */
    public function logout()
    {
        // Hapus token yang sedang digunakan saat ini
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
    /** update profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        //validasi
        $validator = Validator::make($request->all(), [
            'name'      => 'sometimes|required|string|max:255',
            'email'     => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password'  => 'sometimes|required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }
        //update data
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json([
            'message' => 'Profile berhasil diupdate',
            'user' => $user,
        ], 200);
    }
}