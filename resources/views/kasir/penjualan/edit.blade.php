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

    {{-- Tampilkan error validasi kalau ada --}}
    @if ($errors->any())
      <div style="padding:10px 12px;border:1px solid #f97373;
                  background:#fee2e2;color:#b91c1c;border-radius:6px;margin-bottom:12px;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin:6px 0 0 18px;padding:0;font-size:13px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
  </div>

  @php
    // Cari barang yang sesuai dengan penjualan berdasarkan nama_barang
    $selectedBarang = $barangs->firstWhere('nama_barang', $penjualan->nama_barang);
    $defaultBarangId = $selectedBarang->id ?? null;
    $selectedBarangId = old('barang_id', $defaultBarangId);
  @endphp

  <form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST"
        style="background:var(--white);padding:20px;border:1px solid var(--border-color);border-radius:8px;">
    @csrf
    @method('PUT')

    {{-- Nama Pelanggan --}}
    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Nama Pelanggan</label>
      <input type="text"
             name="nama_pelanggan"
             value="{{ old('nama_pelanggan', $penjualan->nama_pelanggan) }}"
             required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

    {{-- Pilih Barang (pakai barang_id, bukan nama_barang) --}}
    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Nama Barang</label>
      <select name="barang_id"
              required
              style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
        <option value="">-- Pilih Barang --</option>
        @foreach ($barangs as $barang)
          <option value="{{ $barang->id }}"
            {{ (string) $selectedBarangId === (string) $barang->id ? 'selected' : '' }}>
            {{ $barang->nama_barang }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Jumlah --}}
    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Jumlah</label>
      <input type="number"
             name="jumlah"
             min="1"
             value="{{ old('jumlah', $penjualan->jumlah) }}"
             required
             style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">
    </div>

    {{-- Total Harga (hanya info, dihitung ulang di backend) --}}
    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Total Harga (info)</label>
      <input type="text"
             value="Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}"
             readonly
             style="width:100%;padding:10px;border:1px solid var(--border-color);
                    border-radius:6px;background:#f9fafb;color:#4b5563;">
    </div>

    {{-- Via Pembayaran (HARUS sama dengan enum di DB) --}}
    <div style="margin-bottom:12px;">
      <label style="display:block;margin-bottom:6px;">Via Pembayaran</label>
      <select name="via"
              required
              style="width:100%;padding:10px;border:1px solid var(--border-color);border-radius:6px;">

        <option value="Tunai" {{ old('via', $penjualan->via) == 'Tunai' ? 'selected' : '' }}>Tunai</option>
        <option value="QRIS" {{ old('via', $penjualan->via) == 'QRIS' ? 'selected' : '' }}>QRIS</option>
        <option value="Transfer" {{ old('via', $penjualan->via) == 'Transfer' ? 'selected' : '' }}>Transfer</option>
        <option value="Hutang" {{ old('via', $penjualan->via) == 'Hutang' ? 'selected' : '' }}>Hutang</option>
      </select>
    </div>

    {{-- Tanggal --}}
    <div style="margin-bottom:16px;">
      <label style="display:block;margin-bottom:6px;">Tanggal</label>
      <input type="date"
             name="tanggal"
             value="{{ old('tanggal', \Carbon\Carbon::parse($penjualan->tanggal)->format('Y-m-d')) }}"
             required
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
