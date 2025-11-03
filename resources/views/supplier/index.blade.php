{{-- resources/views/admin/supplier/index.blade.php --}}
@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Supplier List
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
      <form method="GET" action="{{ route('supplier.index') }}" style="display:flex;gap:0;margin-bottom:12px;align-items:stretch;">
        <input
          type="text"
          name="search"
          value="{{ request('search') }}"
          placeholder="Search supplier by name or email..."
          style="
            flex:1;
            padding:10px 12px;
            border:1px solid var(--border-color);
            border-right:none;
            border-top-left-radius:6px;
            border-bottom-left-radius:6px;
            outline:none;"
        >
        <button type="submit" style="
          padding:10px 16px;
          border:1px solid var(--primary-color);
          background:var(--primary-color);
          color:#fff;
          font-weight:600;
          cursor:pointer;
          border-top-right-radius:6px;
          border-bottom-right-radius:6px;">
          Search
        </button>
      </form>
    </div>

    {{-- Tabel Supplier --}}
    <div style="
      width:100%;
      overflow-x:auto;
      background:var(--white);
      border:1px solid var(--border-color);
      border-radius:8px;">
      <table style="width:100%; border-collapse:collapse; min-width:720px;">
        <thead style="background:#f8f9fb;">
          <tr>
            <th style="text-align:left; padding:10px 12px; border-bottom:1px solid var(--border-color);">Name</th>
            <th style="text-align:left; padding:10px 12px; border-bottom:1px solid var(--border-color);">Email</th>
            <th style="text-align:left; padding:10px 12px; border-bottom:1px solid var(--border-color);">Phone</th>
            <th style="text-align:left; padding:10px 12px; border-bottom:1px solid var(--border-color);">Address</th>
            <th style="text-align:left; padding:10px 12px; border-bottom:1px solid var(--border-color);">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($suppliers as $supplier)
            <tr style="border-bottom:1px solid var(--border-color);">
              <td style="padding:10px 12px;">{{ $supplier->name }}</td>
              <td style="padding:10px 12px;">{{ $supplier->email }}</td>
              <td style="padding:10px 12px;">{{ $supplier->phone }}</td>
              <td style="padding:10px 12px;">{{ $supplier->address }}</td>
              <td style="padding:10px 12px;">
                <div style="display:flex; gap:8px; align-items:center;">
                  <a href="{{ route('supplier.edit', $supplier->id) }}"
                     style="
                      display:inline-block;
                      padding:8px 12px;
                      background:#facc15; /* yellow-400 ish */
                      color:#111;
                      text-decoration:none;
                      border-radius:6px;
                      font-weight:600;">
                    Edit
                  </a>

                  <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST"
                        onsubmit="return confirm('Hapus supplier ini?');" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="
                      padding:8px 12px;
                      background:var(--danger-color);
                      color:#fff;
                      border:none;
                      border-radius:6px;
                      font-weight:600;
                      cursor:pointer;">
                      Delete
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="padding:12px; text-align:center; color:#777;">
                No suppliers found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination (opsional jika pakai paginate()) --}}
    @if (method_exists($suppliers, 'links'))
      <div style="margin-top:8px;">
        {{ $suppliers->appends(['search' => request('search')])->links() }}
      </div>
    @endif

    {{-- Tombol Tambah Supplier --}}
    <div>
      <a href="{{ route('supplier.create') }}"
         style="
          display:inline-block;
          padding:10px 14px;
          background:var(--primary-color);
          color:#fff;
          border-radius:8px;
          font-weight:700;
          text-decoration:none;">
        Create new supplier
      </a>
    </div>
  </div>
@endsection