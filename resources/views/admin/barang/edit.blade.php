@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Edit Barang
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

      <form action="{{ route('barang.update', $barang->id) }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        @method('PUT')

        {{-- KODE --}}
        <div>
          <label for="kode" style="font-size:16px;font-weight:600;color:var(--text-dark);">Kode</label>
          <input type="text" id="kode" name="kode" 
                 value="{{ old('kode', $barang->kode) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box;">
          @error('kode')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- NAMA BARANG --}}
        <div>
          <label for="nama_barang" style="font-size:16px;font-weight:600;color:var(--text-dark);">Nama Barang</label>
          <input type="text" id="nama_barang" name="nama_barang" 
                 value="{{ old('nama_barang', $barang->nama_barang) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box;">
          @error('nama_barang')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- KATEGORI --}}
        <div>
          <label for="kategori" style="font-size:16px;font-weight:600;color:var(--text-dark);">Kategori</label>
          <input type="text" id="kategori" name="kategori" 
                 value="{{ old('kategori', $barang->kategori) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box;">
          @error('kategori')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- STOK --}}
        <div>
          <label for="stok" style="font-size:16px;font-weight:600;color:var(--text-dark);">Stok</label>
          <input type="number" id="stok" name="stok" 
                 value="{{ old('stok', $barang->stok) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box;">
          @error('stok')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- HARGA BELI --}}
        <div>
          <label for="harga_beli" style="font-size:16px;font-weight:600;color:var(--text-dark);">Harga Beli</label>
          <input type="number" id="harga_beli" name="harga_beli" 
                 value="{{ old('harga_beli', $barang->harga_beli) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box;">
          @error('harga_beli')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- HARGA JUAL --}}
        <div>
          <label for="harga_jual" style="font-size:16px;font-weight:600;color:var(--text-dark);">Harga Jual</label>
          <input type="number" id="harga_jual" name="harga_jual" 
                 value="{{ old('harga_jual', $barang->harga_jual) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box;">
          @error('harga_jual')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div style="display:flex;gap:8px;align-items:center;justify-content:flex-start;">
          <button type="submit" style="
            padding:12px 16px;
            background-color:var(--primary-hover);
            color:white;
            border:none;
            border-radius:8px;
            cursor:pointer;
            margin-top:12px;">
            Update
          </button>

          <a href="{{ route('barang.index') }}" style="
            padding:12px 16px;
            background-color:var(--primary-hover);
            color:white;
            border-radius:8px;
            text-decoration:none;
            margin-top:12px;">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
