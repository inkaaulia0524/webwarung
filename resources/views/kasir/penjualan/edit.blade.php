@extends('kasir.layout')

@section('content')
<div style="display:flex;flex-direction:column;gap:16px;">
  <div>
    <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
      Edit Data Penjualan
    </h2>
    <p style="margin:0 0 12px 0;font-size:13px;color:#6b7280;">
      Ubah data transaksi penjualan berikut sesuai kebutuhan.
    </p>
  </div>

  <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST"
        style="background:var(--white);padding:20px;border:1px solid var(--border-color);border-radius:8px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Nama Pelanggan</label>
      <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan', $penjualan->nama_pelanggan) }}" required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Nama Barang</label>
      <select name="nama_barang" required
              style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
        <option value="">-- Pilih Barang --</option>
        @foreach ($barangs as $barang)
          <option value="{{ $barang->nama_barang }}" 
            {{ old('nama_barang', $penjualan->nama_barang) == $barang->nama_barang ? 'selected' : '' }}>
            {{ $barang->nama_barang }}
          </option>
        @endforeach
      </select>
    </div>

    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Jumlah</label>
      <input type="number" name="jumlah" min="1" value="{{ old('jumlah', $penjualan->jumlah) }}" required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Total Harga</label>
      <input type="number" name="total_harga" min="0" value="{{ old('total_harga', $penjualan->total_harga) }}" required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Via Pembayaran</label>
      <select name="via" required
              style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
        <option value="tunai" {{ old('via', $penjualan->via) == 'tunai' ? 'selected' : '' }}>Tunai</option>
        <option value="qris" {{ old('via', $penjualan->via) == 'qris' ? 'selected' : '' }}>QRIS</option>
      </select>
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:6px;">Tanggal</label>
      <input type="date" name="tanggal" value="{{ old('tanggal', $penjualan->tanggal) }}" required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

    <div style="display:flex;justify-content:space-between;">
      <a href="{{ route('penjualan.index') }}"
         style="background:#6b7280;color:white;padding:10px 16px;border-radius:6px;
                text-decoration:none;font-weight:600;">
        Kembali
      </a>
      <button type="submit"
              style="background:var(--primary-color);color:white;padding:10px 16px;border:none;
                     border-radius:6px;cursor:pointer;font-weight:600;">
        Update
      </button>
    </div>
  </form>
</div>
@endsection
