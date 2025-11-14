@extends('kasir.layout')

@section('content')
<div style="display:flex;flex-direction:column;gap:16px;">
  <div>
    <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
      Data Penjualan (Kasir)
    </h2>
    <p style="margin:0 0 12px 0;font-size:13px;color:#6b7280;">
      Halaman ini digunakan untuk melihat, menambah, dan mengelola transaksi penjualan.
    </p>

    {{-- Form Pencarian Penjualan --}}
    <form method="GET"
          action="{{ route('penjualan.index') }}"
          style="display:flex;gap:0;margin-bottom:12px;align-items:stretch;">
      <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari nama pelanggan / barang..."
        style="flex:1;padding:12px 16px;border:1px solid var(--border-color);border-right:none;
               border-top-left-radius:6px;border-bottom-left-radius:6px;outline:none;">
      <button type="submit"
              style="padding:12px 16px;border:1px solid var(--primary-color);
                     background:var(--primary-color);color:white;font-weight:600;cursor:pointer;
                     border-top-right-radius:6px;border-bottom-right-radius:6px;">
        Search
      </button>
    </form>

    {{-- Tombol Tambah --}}
    <div style="display:flex;justify-content:flex-end;margin-bottom:8px;">
      <a href="{{ route('penjualan.create') }}"
         style="background:var(--primary-color);color:var(--white);padding:10px 16px;
                border-radius:6px;text-decoration:none;font-weight:600;">
        + Tambah Penjualan
      </a>
    </div>
  </div>

  {{-- Tabel Penjualan --}}
  <div style="width:100%;overflow-x:auto;background:var(--white);
              border:1px solid var(--border-color);border-radius:8px;">
    <table style="width:100%;border-collapse:collapse;min-width:900px;">
      <thead style="background:#f8f9fb;">
        <tr>
          <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">No</th>
          <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Nama Pelanggan</th>
          <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Nama Barang</th>
          <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Jumlah</th>
          <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Total Harga</th>
          <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Via</th>
          <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Tanggal</th>
          <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($penjualans as $penjualan)
          <tr style="border-bottom:1px solid var(--border-color);">
            <td style="padding:10px 12px;">{{ $loop->iteration }}</td>
            <td style="padding:10px 12px;">{{ $penjualan->nama_pelanggan }}</td>
            <td style="padding:10px 12px;">{{ $penjualan->nama_barang }}</td>
            <td style="padding:10px 12px;">{{ $penjualan->jumlah }}</td>
            <td style="padding:10px 12px;">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
            <td style="padding:10px 12px;">{{ ucfirst($penjualan->via) }}</td>
            <td style="padding:10px 12px;">{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d-m-Y') }}</td>
            <td style="padding:10px 12px;display:flex;gap:6px;">
              <a href="{{ route('penjualan.edit', $penjualan->id) }}"
                 style="background:#ffcc00;color:#333;padding:6px 10px;border-radius:4px;
                        text-decoration:none;font-weight:600;">Edit</a>
              <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        style="background:#cc0000;color:white;padding:6px 10px;border:none;border-radius:4px;cursor:pointer;">
                  Hapus
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" style="padding:12px;text-align:center;color:#6b7280;">
              Tidak ada data penjualan.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if (method_exists($penjualans, 'links'))
    <div style="margin-top:8px;">
      {{ $penjualans->appends(['search' => request('search')])->links() }}
    </div>
  @endif
</div>
@endsection
