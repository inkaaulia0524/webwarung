@extends('kasir.layout')

@section('content')
<div style="display:flex;flex-direction:column;gap:16px;">
  <div>
    <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
      Tambah Data Penjualan
    </h2>
    <p style="margin:0 0 12px 0;font-size:13px;color:#6b7280;">
      Isi formulir berikut untuk menambahkan transaksi penjualan baru.
    </p>
  </div>

  <form action="{{ route('penjualan.store') }}" method="POST"
        style="background:var(--white);padding:20px;border:1px solid var(--border-color);border-radius:8px;">
    @csrf

    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Nama Pelanggan</label>
      <input type="text" name="nama_pelanggan" required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

<div style="margin-bottom:12px;">
  <label style="display:block;margin-bottom:6px;">Nama Barang</label>
  <select name="barang_id" required
          style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    <option value="">-- Pilih Barang --</option>
    @foreach ($barangs as $barang)
      <option value="{{ $barang->id }}">{{ $barang->nama_barang }} (Stok: {{ $barang->stok }})</option>
    @endforeach
  </select>
</div>



    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Jumlah</label>
      <input type="number" name="jumlah" min="1" required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Total Harga</label>
      <input type="number" name="total_harga" min="0" required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Via Pembayaran</label>
      <select name="via" required
              style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
        <option value="tunai">Tunai</option>
        <option value="qris">QRIS</option>
      </select>
    </div>

    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:6px;">Tanggal</label>
      <input type="date" name="tanggal" required
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
        Simpan
      </button>
    </div>
  </form>
</div>
@endsection
