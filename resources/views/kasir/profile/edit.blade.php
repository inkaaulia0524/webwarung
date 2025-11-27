@extends('kasir.layout')

@section('content')
<div style="display:flex;flex-direction:column;gap:16px;">

    <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Edit profil kasir
    </h2>

    {{-- 🔔 Notif Berhasil --}}
    @if (session('success'))
        <div style="
            background:#e8f8ed;
            padding:12px 16px;
            border-radius:8px;
            border:1px solid #b7e4c7;
            color:#1b4332;
            font-weight:600;
            margin-bottom:12px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('kasir.profile.update') }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        @method('PATCH')

        {{-- Nama --}}
        <div>
            <label for="name" style="font-size:16px;font-weight:600;color:var(--text-dark);">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                   style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;font-size:14px;width:100%;">
            @error('name') <p style="color:#e00;font-size:12px;">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" style="font-size:16px;font-weight:600;color:var(--text-dark);">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                   style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;font-size:14px;width:100%;">
            @error('email') <p style="color:#e00;font-size:12px;">{{ $message }}</p> @enderror
        </div>

        {{-- Password Baru --}}
        <div>
            <label for="password" style="font-size:16px;font-weight:600;color:var(--text-dark);">
                Password Baru (Opsional)</label>
            <input type="password" id="password" name="password"
                   style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;font-size:14px;width:100%;">
            @error('password') <p style="color:#e00;font-size:12px;">{{ $message }}</p> @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" style="font-size:16px;font-weight:600;color:var(--text-dark);">
                Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;font-size:14px;width:100%;">
        </div>

        <button type="submit" style="
            padding:12px 20px;background:var(--primary-color);color:white;font-size:16px;font-weight:600;
            border-radius:8px;width:100%;cursor:pointer;border:none;transition:.3s;">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
