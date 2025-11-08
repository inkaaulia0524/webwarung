@extends('kasir.layout') {{-- pakai layout yang sama biar UI konsisten --}}

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Stok Barang (Kasir)
      </h2>
      <p style="margin:0 0 12px 0;font-size:13px;color:#6b7280;">
        Halaman ini hanya untuk melihat dan mencari data barang. Kasir tidak dapat mengubah data.
      </p>

      {{-- Form Pencarian Barang --}}
      <form method="GET"
            action="{{ route('stok.index') }}"
            style="display:flex;gap:0;margin-bottom:12px;align-items:stretch;">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Cari barang..."
          style="flex:1;padding:12px 16px;border:1px solid var(--border-color);border-right:none;
                 border-top-left-radius:6px;border-bottom-left-radius:6px;outline:none;">
        <button type="submit"
                style="padding:12px 16px;border:1px solid var(--primary-color);
                       background:var(--primary-color);color:white;font-weight:600;cursor:pointer;
                       border-top-right-radius:6px;border-bottom-right-radius:6px;">
          Search
        </button>
      </form>
    </div>

    {{-- Tabel Barang (Read-Only) --}}
    <div style="width:100%;overflow-x:auto;background:var(--white);
                border:1px solid var(--border-color);border-radius:8px;">
      <table style="width:100%;border-collapse:collapse;min-width:720px;">
        <thead style="background:#f8f9fb;">
          <tr>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Kode</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Nama Barang</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Kategori</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Harga Beli</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Harga Jual</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Stok</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($barangs as $barang)
            <tr style="border-bottom:1px solid var(--border-color);">
              <td style="padding:10px 12px;">{{ $barang->kode }}</td>
              <td style="padding:10px 12px;">{{ $barang->nama_barang }}</td>
              <td style="padding:10px 12px;">{{ $barang->kategori }}</td>
              <td style="padding:10px 12px;">{{ number_format($barang->harga_beli, 2) }}</td>
              <td style="padding:10px 12px;">{{ number_format($barang->harga_jual, 2) }}</td>
              <td style="padding:10px 12px;">{{ $barang->stok }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="padding:12px;text-align:center;color:#6b7280;">
                Tidak ada data barang.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if (method_exists($barangs, 'links'))
      <div style="margin-top:8px;">
        {{ $barangs->appends(['search' => request('search')])->links() }}
      </div>
    @endif
  </div>
@endsection
