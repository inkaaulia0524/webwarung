@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        {{-- DIUBAH --}}
        Edit Pembelian
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
      
      {{-- Menampilkan error validasi --}}
      @if ($errors->any())
        <div style="
          padding:10px 12px;
          border:1px solid #f5c6cb;
          background:#f8d7da;
          color:#721c24;
          border-radius:6px;
          margin-bottom:12px;">
            <strong>Oops! Ada yang salah:</strong>
            <ul style="margin:8px 0 0 20px; padding:0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
      @endif

      {{-- Form Edit Pembelian --}}
      {{-- DIUBAH: action ke route 'update' dan $pembelian->id --}}
      <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        @method('PUT') {{-- DIUBAH: Method 'PUT' untuk update --}}
        
        {{-- Dropdown Nama Barang --}}
        <div>
          <label for="barang_id" style="font-size:16px;font-weight:600;color:var(--text-dark);">Nama Barang</label>
          <select id="barang_id" name="barang_id" required
                  style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box; background:white;">
              <option value="">-- Pilih Barang --</option>
              @foreach ($barangs as $barang)
                  {{-- DIUBAH: Tambahkan $pembelian->barang_id sebagai default --}}
                  <option value="{{ $barang->id }}" {{ old('barang_id', $pembelian->barang_id) == $barang->id ? 'selected' : '' }}>
                      {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                  </option>
              @endforeach
          </select>
          @error('barang_id')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- Dropdown Nama Supplier --}}
        <div>
          <label for="supplier_id" style="font-size:16px;font-weight:600;color:var(--text-dark);">Supplier</label>
          <select id="supplier_id" name="supplier_id" required
                  style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box; background:white;">
              <option value="">-- Pilih Supplier --</option>
              @foreach ($suppliers as $supplier)
                  {{-- DIUBAH: Tambahkan $pembelian->supplier_id sebagai default --}}
                  <option value="{{ $supplier->id }}" {{ old('supplier_id', $pembelian->supplier_id) == $supplier->id ? 'selected' : '' }}>
                      {{ $supplier->name }} </option>
              @endforeach
          </select>
          @error('supplier_id')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- Input Jumlah --}}
        <div>
          <label for="jumlah" style="font-size:16px;font-weight:600;color:var(--text-dark);">Jumlah Masuk</label>
          {{-- DIUBAH: Tambahkan $pembelian->jumlah sebagai default --}}
          <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $pembelian->jumlah) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box;">
          @error('jumlah')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        {{-- Input Tanggal --}}
        <div>
          <label for="tanggal_masuk" style="font-size:16px;font-weight:600;color:var(--text-dark);">Tanggal Masuk</label>
          {{-- DIUBAH: Ganti default 'date()' menjadi data dari $pembelian --}}
          <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk', $pembelian->tanggal_masuk->format('Y-m-d')) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;box-sizing:border-box;">
          @error('tanggal_masuk')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>


        <div style="display: flex; gap: 8px; align-items: center; justify-content: flex-start;">
          {{-- DIUBAH: Ganti teks tombol --}}
          <button type="submit" style="padding:8px 14px;background-color:var(--primary-hover);color:white;font-size:16px;font-weight:600;border-radius:8px;width:auto;border:none;cursor:pointer;">
            Update
          </button>

          <a href="{{ route('pembelian.index') }}" style="padding:8px 14px;background-color:var(--primary-hover);color:white;font-size:16px;font-weight:600;border-radius:8px;width:auto;text-decoration:none;display:inline-block;">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection