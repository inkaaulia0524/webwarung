@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Edit Hutang Piutang
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

      <form action="{{ route('hutangpiutang.update', $hutang->id) }}" method="POST"
            style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        @method('PUT')

        {{-- Tanggal --}}
        <div>
          <label for="tanggal" style="font-size:16px;font-weight:600;color:var(--text-dark);">Tanggal</label>
          <input type="date" id="tanggal" name="tanggal"
                 value="{{ old('tanggal', $hutang->tanggal) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);
                        border-radius:8px;width:100%;">
          @error('tanggal')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- Nama Pelanggan --}}
        <div>
          <label for="nama_pelanggan" style="font-size:16px;font-weight:600;color:var(--text-dark);">
            Nama Pelanggan
          </label>
          <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                 value="{{ old('nama_pelanggan', $hutang->nama_pelanggan) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);
                        border-radius:8px;width:100%;">
          @error('nama_pelanggan')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- Nominal --}}
        <div>
          <label for="nominal" style="font-size:16px;font-weight:600;color:var(--text-dark);">
            Nominal Hutang
          </label>
          <input type="number" id="nominal" name="nominal" min="1"
                 value="{{ old('nominal', $hutang->nominal) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);
                        border-radius:8px;width:100%;">
          @error('nominal')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- Jatuh Tempo --}}
        <div>
          <label for="jatuh_tempo" style="font-size:16px;font-weight:600;color:var(--text-dark);">
            Jatuh Tempo (Opsional)
          </label>
          <input type="date" id="jatuh_tempo" name="jatuh_tempo"
                 value="{{ old('jatuh_tempo', $hutang->jatuh_tempo) }}"
                 style="padding:12px 16px;border:1px solid var(--border-color);
                        border-radius:8px;width:100%;">
          @error('jatuh_tempo')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div style="display:flex;gap:8px;">
          <button type="submit"
                  style="padding:10px 14px;background-color:var(--primary-color);
                         color:white;font-weight:700;border:none;border-radius:8px;cursor:pointer;">
            Update
          </button>

          <a href="{{ route('hutangpiutang.index') }}"
             style="padding:10px 14px;background-color:var(--primary-color);
                    color:white;font-weight:700;text-decoration:none;border-radius:8px;">
            Kembali
          </a>
        </div>

      </form>
    </div>
  </div>
@endsection
