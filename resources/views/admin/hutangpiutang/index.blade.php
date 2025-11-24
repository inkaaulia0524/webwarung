@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">

    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Data Hutang Piutang
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

      {{-- Form Pencarian --}}
      <form method="GET" action="{{ route('hutangpiutang.index') }}"
            style="display:flex;gap:0;margin-bottom:12px;align-items:stretch;">
        <input
          type="text"
          name="search"
          value="{{ $search ?? '' }}"
          placeholder="Cari nama pelanggan / nominal / tanggal..."
          style="flex:1;padding:12px 16px;border:1px solid var(--border-color);
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

    {{-- Tabel Hutang Piutang --}}
    <div style="width:100%;overflow-x:auto;background:var(--white);
                border:1px solid var(--border-color);border-radius:8px;">

      <table style="width:100%;border-collapse:collapse;min-width:720px;">
        <thead style="background:#f8f9fb;">
          <tr>
            <th style="padding:10px 12px;border-bottom:1px solid var(--border-color);">Tanggal</th>
            <th style="padding:10px 12px;border-bottom:1px solid var(--border-color);">Nama Pelanggan</th>
            <th style="padding:10px 12px;border-bottom:1px solid var(--border-color);">Nominal</th>
            <th style="padding:10px 12px;border-bottom:1px solid var(--border-color);">Jatuh Tempo</th>
            <th style="padding:10px 12px;border-bottom:1px solid var(--border-color);">Actions</th>
          </tr>
        </thead>

        <tbody>
          @forelse ($hutang as $item)
            <tr style="border-bottom:1px solid var(--border-color);">
              <td style="padding:10px 12px;">
                {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
              </td>

              <td style="padding:10px 12px;">
                {{ $item->nama_pelanggan }}
              </td>

              <td style="padding:10px 12px;">
                Rp {{ number_format($item->nominal,0,',','.') }}
              </td>

              <td style="padding:10px 12px;">
                {{ $item->jatuh_tempo ? \Carbon\Carbon::parse($item->jatuh_tempo)->format('d-m-Y') : '-' }}
              </td>

              <td style="padding:10px 12px;">
                <div style="display:flex;gap:8px;align-items:center;">

                  {{-- Edit --}}
                  <a href="{{ route('hutangpiutang.edit', $item->id) }}"
                     style="padding:8px 12px;background:#facc15;color:#111;
                            text-decoration:none;border-radius:6px;font-weight:600;">
                    Edit
                  </a>

                  {{-- Delete (Selesai Bayar) --}}
                  <form action="{{ route('hutangpiutang.destroy', $item->id) }}"
                        method="POST"
                        onsubmit="return confirm('Hapus data hutang ini? Penjualan tetap aman.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            style="padding:8px 12px;background:#e53e3e;color:white;
                                   border:none;border-radius:6px;font-weight:600;cursor:pointer;">
                      sudah bayar
                    </button>
                  </form>

                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="padding:12px;text-align:center;color:#6b7280;">
                Belum ada data hutang piutang.
              </td>
            </tr>
          @endforelse
        </tbody>

      </table>
    </div>

    {{-- Pagination --}}
    @if (method_exists($hutang, 'links'))
      <div style="margin-top:8px;">
        {{ $hutang->appends(['search' => $search])->links() }}
      </div>
    @endif

  </div>
@endsection
