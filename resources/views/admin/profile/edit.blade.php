@extends('admin.layout')

@section('content')
   <div style ="display:flex;flex-direction:column;gap:16px;">
    <div>
    <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Edit profil admin
    </h2>

    @if (session('success'))
        <div style="
          padding:10px 12px;
          border:1px solid var(--border-color);
          background:#eefaf0;
          color:#1f7a1f;
          border-radius:6px;
          margin-bottom:12px;">
          {{ session('success') }}
        </div>
    @endif
    {{-- form edit profile --}}
    <form action="{{ route('profile.edit') }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        <div>
            <label for="name" style="font-size:16px;font-weight:600;color:var(--text-dark);">Nama</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required
                 style="
                   padding:12px 16px;
                   border:1px solid var(--border-color);
                   border-radius:8px;
                   font-size:14px;
                   color:var(--text-dark);
                   outline:none;
                   width:100%;
                   box-sizing:border-box;">
          @error('name')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
            <label for="email" style="font-size:16px;font-weight:600;color:var(--text-dark);">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required
                 style="
                   padding:12px 16px;
                   border:1px solid var(--border-color);
                   border-radius:8px;
                   font-size:14px;
                   color:var(--text-dark);
                   outline:none;
                   width:100%;
                   box-sizing:border-box;">
          @error('email')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
            <label for="password" style="font-size:16px;font-weight:600;color:var(--text-dark);">Password Baru</label>
          <input type="password" id="password" name="password"
                 style="
                   padding:12px 16px;
                   border:1px solid var(--border-color);
                   border-radius:8px;
                   font-size:14px;
                   color:var(--text-dark);
                   outline:none;
                   width:100%;
                   box-sizing:border-box;">
          @error('password')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <button type="submit" style="
          display:inline-block;
          padding:12px 20px;
          background-color:var(--primary-color);
          color:white;
          font-size:16px;
          font-weight:600;
          border-radius:8px;
          cursor:pointer;
          width:100%;
          border:none;
          transition:background-color 0.3s;">
          Simpan Perubahan
        </button>
    </form>
@endsection
