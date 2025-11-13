@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Data Pembelian (Barang Masuk)
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

      
      <form method="GET" action="{{ route('pembelian.index') }}" 
            style="display:flex;gap:0;margin-bottom:12px;align-items:stretch;">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Cari (nama barang / supplier)..." style="flex:1;padding:12px 16px;border:1px solid var(--border-color);
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

    <div style="width:100%;overflow-x:auto;background:var(--white);
                border:1px solid var(--border-color);border-radius:8px;">
      <table style="width:100%;border-collapse:collapse;min-width:720px;">
        <thead style="background:#f8f9fb;">
          <tr>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">No</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Nama Barang</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Supplier</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Jumlah Masuk</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Tanggal Masuk</th>
            <th style="text-align:left;padding:10px 12px;border-bottom:1px solid var(--border-color);">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($pembelians as $pembelian)
            <tr style="border-bottom:1px solid var(--border-color);">
              <td style="padding:10px 12px;">{{ $loop->iteration }}</td>
              <td style="padding:10px 12px;">{{ $pembelian->barang->nama_barang ?? 'Barang Dihapus' }}</td>
              <td style="padding:10px 12px;">{{ $pembelian->supplier->name ?? 'Supplier Dihapus' }}</td>
              <td style="padding:10px 12px;">{{ $pembelian->jumlah }}</td>
              <td style="padding:10px 12px;">{{ \Carbon\Carbon::parse($pembelian->tanggal_masuk)->format('d-m-Y') }}</td>
              
              <td style="padding:10px 12px;">
                <div style="display:flex;gap:8px;align-items:center;">
                  <a href="{{ route('pembelian.edit', $pembelian->id) }}" 
                     style="padding:8px 12px;background:#facc15;color:#111;
                            text-decoration:none;border-radius:6px;font-weight:600;">
                    Edit
                  </a>

                  <form action="{{ route('pembelian.destroy', $pembelian->id) }}" 
                        method="POST" 
                        onsubmit="return confirm('Hapus data ini? Stok barang akan dikurangi.');"
                        style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            style="padding:8px 12px;background:#e53e3e;
                                   color:white;border:none;border-radius:6px;
                                   font-weight:600;cursor:pointer;">
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" style="padding:12px;text-align:center;">Data pembelian masih kosong.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if (method_exists($pembelians, 'links'))
      <div style="margin-top:8px;">
        {{ $pembelians->appends(['search' => request('search')])->links() }}
      </div>
    @endif

    <div>
      <a href="{{ route('pembelian.create') }}" 
         style="display:inline-block;padding:10px 14px;
                background-color:var(--primary-color);
                color:white;font-weight:700;text-decoration:none;
                border-radius:8px;margin-top:12px;">
        Add New Purchase
      </a>
    </div>
  </div>
@endsection