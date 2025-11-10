@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Data Pengeluaran Barang
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

      {{-- Form Pencarian Pengeluaran --}}
      <form method="GET" action="{{ route('pengeluaran.index') }}"
            style="display:flex;gap:0;margin-bottom:12px;align-items:stretch;">
        <input
          type="text"
          name="search"
          value="{{ $search ?? '' }}"
          placeholder="Cari kode / nama barang / alasan..."
          style="flex:1;padding:12px 16px;border:1px solid(var(--border-color));
                 border-right:none;border-top-left-radius:6px;
                 border-bottom-left-radius:6px;outline:none;">
        <button type="submit"
                style="padding:12px 16px;border:1px solid var(--primary-color);
                       background:var(--primary-color);color:white;
                       font-weight:600;cursor:pointer;
                       border-top-right-radius:6px;border-bottom-right-radius:6px;">
          Search
        </button>
      </form>
    </div>

    {{-- Tabel Pengeluaran --}}
    <div style="width:100%;overflow-x:auto;background:var(--white);
                border:1px solid var(--border-color);border-radius:8px;">
      <table style="width:100%;border-collapse:collapse;min-width:720px;">
        <thead style="background:#f8f9fb;">
          <tr>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Tanggal</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Kode</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Nama Barang</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Alasan</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Jumlah</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Keterangan</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pengeluaran as $item)
            <tr style="border-bottom:1px solid var(--border-color);">
              <td style="padding:10px 12px;">{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
              <td style="padding:10px 12px;">{{ $item->barang->kode ?? '-' }}</td>
              <td style="padding:10px 12px;">{{ $item->barang->nama_barang ?? '-' }}</td>
              <td style="padding:10px 12px;">{{ ucfirst($item->alasan) }}</td>
              <td style="padding:10px 12px;">{{ $item->jumlah }}</td>
              <td style="padding:10px 12px;">{{ $item->keterangan ?? '-' }}</td>
              <td style="padding:10px 12px;">
                <div style="display:flex;gap:8px;align-items:center;">
                  <a href="{{ route('pengeluaran.edit', $item->id) }}" 
                     style="padding:8px 12px;background:#facc15;color:#111;
                            text-decoration:none;border-radius:6px;font-weight:600;">
                    Edit
                  </a>
                <form action="{{ route('pengeluaran.destroy', $item->id) }}"
                      method="POST"
                      onsubmit="return confirm('Hapus data ini? Stok akan dikembalikan.');"
                      style="display:inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          style="padding:8px 12px;background:#e53e3e;color:white;
                                 border:none;border-radius:6px;font-weight:600;cursor:pointer;">
                    Delete
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" style="padding:12px;text-align:center;color:#6b7280;">
                Belum ada data pengeluaran barang.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if (method_exists($pengeluaran, 'links'))
      <div style="margin-top:8px;">
        {{ $pengeluaran->appends(['search' => $search])->links() }}
      </div>
    @endif

    {{-- Tombol Tambah Pengeluaran --}}
    <div>
      <a href="{{ route('pengeluaran.create') }}"
         style="display:inline-block;padding:10px 14px;
                background-color:var(--primary-color);
                color:white;font-weight:700;text-decoration:none;
                border-radius:8px;margin-top:12px;">
        Tambah Pengeluaran Barang
      </a>
    </div>
  </div>
@endsection
