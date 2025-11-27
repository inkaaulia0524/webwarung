@extends('admin.layout')

@section('content')
<div style ="display:flex;flex-direction:column;gap:16px;">
    <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Edit profil admin
    </h2>

    @if (session('status'))
        <div style="
          padding:10px 12px;
          border:1px solid var(--border-color);
          background:#eefaf0;
          color:#1f7a1f;
          border-radius:6px;
          margin-bottom:12px;">
          {{ session('status') }}
        </div>
    @endif

    {{-- form edit admin --}}
    <form action="{{ route('profile.update') }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        @method('PATCH')

        <div>
            <label for="name" style="font-size:16px;font-weight:600;color:var(--text-dark);">Nama</label>
            <input type="text" id="name" name="name" 
                   value="{{ old('name', auth()->user()->name) }}" required
                   style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;font-size:14px;width:100%;">
            @error('name') <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" style="font-size:16px;font-weight:600;color:var(--text-dark);">Email</label>
            <input type="email" id="email" name="email" 
                   value="{{ old('email', auth()->user()->email) }}" required
                   style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;font-size:14px;width:100%;">
            @error('email') <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p> @enderror
        </div>

<div>
    <label for="password" style="font-size:16px;font-weight:600;color:var(--text-dark);">Password Baru (Opsional)</label>
    <input type="password" id="password" name="password"
           style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;font-size:14px;width:100%;">
    @error('password') 
        <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p> 
    @enderror
</div>

<div>
    <label for="password_confirmation" style="font-size:16px;font-weight:600;color:var(--text-dark);">
        Konfirmasi Password
    </label>
    <input type="password" id="password_confirmation" name="password_confirmation"
           style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;font-size:14px;width:100%;">
</div>


        <button type="submit" style="
          padding:12px 20px;
          background-color:var(--primary-color);
          color:white;
          font-size:16px;
          font-weight:600;
          border-radius:8px;
          cursor:pointer;">
          Simpan Perubahan
        </button>
    </form>
@endsection
