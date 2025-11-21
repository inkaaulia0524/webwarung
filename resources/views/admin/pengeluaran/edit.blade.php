@extends('admin.layout')

@section('content')
  <div style="display:flex;flex-direction:column;gap:16px;">
    <div>
      <h2 style="margin:0 0 8px 0;font-size:24px;font-weight:700;color:var(--text-dark);">
        Edit Pengeluaran Barang
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

      <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST" style="display:flex;flex-direction:column;gap:16px;">
        @csrf
        @method('PUT')

        <div>
          <label for="tanggal" style="font-size:16px;font-weight:600;color:var(--text-dark);">Tanggal</label>
          <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $pengeluaran->tanggal) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;">
          @error('tanggal')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="barang_id" style="font-size:16px;font-weight:600;color:var(--text-dark);">Pilih Barang</label>
          <select id="barang_id" name="barang_id" required
                  style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;">
            @foreach ($barangs as $barang)
              <option value="{{ $barang->id }}" {{ old('barang_id', $pengeluaran->barang_id) == $barang->id ? 'selected' : '' }}>
                {{ $barang->kode }} - {{ $barang->nama_barang }}
              </option>
            @endforeach
          </select>
          @error('barang_id')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="jumlah" style="font-size:16px;font-weight:600;color:var(--text-dark);">Jumlah</label>
          <input type="number" id="jumlah" name="jumlah" min="1" value="{{ old('jumlah', $pengeluaran->jumlah) }}" required
                 style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;">
          @error('jumlah')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="alasan" style="font-size:16px;font-weight:600;color:var(--text-dark);">Alasan Pengeluaran</label>
          <select id="alasan" name="alasan" required
                  style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;">
            @foreach (['rusak', 'hilang', 'kadaluwarsa', 'internal', 'lainnya'] as $alasan)
              <option value="{{ $alasan }}" {{ old('alasan', $pengeluaran->alasan) == $alasan ? 'selected' : '' }}>
                {{ ucfirst($alasan) }}
              </option>
            @endforeach
          </select>
          @error('alasan')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="keterangan" style="font-size:16px;font-weight:600;color:var(--text-dark);">Keterangan (Opsional)</label>
          <textarea id="keterangan" name="keterangan" rows="3"
                    style="padding:12px 16px;border:1px solid var(--border-color);border-radius:8px;width:100%;">{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
          @error('keterangan')
            <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
          @enderror
        </div>

        <div style="display:flex;gap:8px;">
          <button type="submit" style="padding:10px 14px;background-color:var(--primary-color);color:white;font-weight:700;border:none;border-radius:8px;cursor:pointer;">
            Update
          </button>

          <a href="{{ route('pengeluaran.index') }}" style="padding:10px 14px;background-color:var(--primary-color);color:white;font-weight:700;text-decoration:none;border-radius:8px;">
            Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection
