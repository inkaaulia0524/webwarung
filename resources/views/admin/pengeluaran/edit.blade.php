@extends('admin.layout')

@section('content')

<style>
    /* Style global agar semua input seragam */
    .form-input {
        padding: 12px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        width: 100%;
        box-sizing: border-box;
        font-size: 14px;
    }
</style>

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

        <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" 
              method="POST"
              style="display:flex;flex-direction:column;gap:16px;">
            @csrf
            @method('PUT')

            {{-- Tanggal --}}
            <div>
                <label style="font-size:16px;font-weight:600;color:var(--text-dark);">Tanggal</label>
                <input type="date" name="tanggal" 
                    value="{{ old('tanggal', $pengeluaran->tanggal) }}"
                    required class="form-input">
                @error('tanggal')
                    <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Barang --}}
            <div>
                <label style="font-size:16px;font-weight:600;color:var(--text-dark);">Pilih Barang</label>
                <select name="barang_id" required class="form-input">
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}"
                            {{ $barang->id == $pengeluaran->barang_id ? 'selected' : '' }}>
                            {{ $barang->kode }} - {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label style="font-size:16px;font-weight:600;color:var(--text-dark);">Jumlah</label>
                <input type="number" name="jumlah" min="1"
                       value="{{ old('jumlah', $pengeluaran->jumlah) }}"
                       required class="form-input">
                @error('jumlah')
                    <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alasan --}}
            <div>
                <label style="font-size:16px;font-weight:600;color:var(--text-dark);">Alasan Pengeluaran</label>
                <select name="alasan" required class="form-input">
                    <option value="rusak"       {{ $pengeluaran->alasan == 'rusak' ? 'selected' : '' }}>Barang Rusak</option>
                    <option value="hilang"      {{ $pengeluaran->alasan == 'hilang' ? 'selected' : '' }}>Hilang</option>
                    <option value="kadaluwarsa" {{ $pengeluaran->alasan == 'kadaluwarsa' ? 'selected' : '' }}>Kadaluwarsa</option>
                    <option value="internal"    {{ $pengeluaran->alasan == 'internal' ? 'selected' : '' }}>Keperluan Internal</option>
                    <option value="lainnya"     {{ $pengeluaran->alasan == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('alasan')
                    <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div>
                <label style="font-size:16px;font-weight:600;color:var(--text-dark);">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3"
                          class="form-input">{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
                @error('keterangan')
                    <p style="color:#cc0000;font-size:12px;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div style="display:flex;gap:8px;">
                <button type="submit"
                        style="padding:10px 14px;background-color:var(--primary-color);
                               color:white;font-weight:700;border:none;border-radius:8px;cursor:pointer;">
                    Update
                </button>

                <a href="{{ route('pengeluaran.index') }}"
                   style="padding:10px 14px;background-color:var(--primary-color);
                          color:white;font-weight:700;text-decoration:none;border-radius:8px;">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>

@endsection
