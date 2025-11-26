@extends('admin.layout') {{-- Asumsi layout kamu seperti ini --}}

@section('content')
<style>
    input[readonly] {
        background-color: #eee; 
        cursor: not-allowed; 
    }
    .form-container {
        background-color: var(--white);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        font-size: 1rem;
    }
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        text-decoration: none;
    }
    .btn-primary {
        background-color: #0d6efd;
        color: white;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .form-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }
</style>

<div class="form-container">
    <h2>Tambah Data Penjualan</h2>
    <p>Isi formulir untuk menambahkan transaksi penjualan baru.</p>

    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 1rem; border-radius: 5px; margin-bottom: 1rem;">
            <strong>Error!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" value="{{ old('nama_pelanggan') }}" required>
        </div>

        <div class="form-group">
            <label for="barang_id">Nama Barang</label>
            <select id="barang_id" name="barang_id" class="form-control" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" data-stok="{{ $barang->stok }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                        {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                    </option>
                @endforeach
            </select>
            <small id="stok-warning" style="color: red; display: none;">Stok tidak mencukupi!</small>
        </div>

        <div class="form-group">
            <label for="jumlah">Jumlah</label>
            <input type="number" id="jumlah" name="jumlah" class="form-control" value="{{ old('jumlah') }}" min="1" required>
        </div>

        <div class="form-group">
            <label for="total_harga">Total Harga</label>
            {{-- Buat jadi readonly agar tidak bisa diubah manual --}}
            <input type="number" id="total_harga" name="total_harga" class="form-control" value="{{ old('total_harga') }}" readonly required>
        </div>

        <div class="form-group">
            <label for="via">Via Pembayaran</label>
            <select id="via" name="via" class="form-control" required>
                <option value="Tunai" {{ old('via') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                <option value="Transfer" {{ old('via') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                <option value="QRIS" {{ old('via') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                <option value='Hutang' {{ old('via') == 'Hutang' ? 'selected' : '' }}>Hutang</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="datetime-local" id="tanggal" name="tanggal" class="form-control" value="{{ old('tanggal', now()->format('Y-m-d\TH:i')) }}" required>
        </div>

        <div class="form-actions">
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" id="submit-button" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    const barangsData = {!! $barangs->keyBy('id') !!};

    const barangSelect = document.getElementById('barang_id');
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaInput = document.getElementById('total_harga');
    const stokWarning = document.getElementById('stok-warning');
    const submitButton = document.getElementById('submit-button');

    function calculateTotal() {
        const barangId = barangSelect.value;
        const jumlah = parseInt(jumlahInput.value);
        
        stokWarning.style.display = 'none';
        submitButton.disabled = false;

        if (barangId && jumlah > 0) {
            const selectedBarang = barangsData[barangId];
            
            if (jumlah > selectedBarang.stok) {
                stokWarning.style.display = 'block'; 
                submitButton.disabled = true; 
                totalHargaInput.value = 0; 
            } else {
                const hargaJual = parseFloat(selectedBarang.harga_jual);
                const total = hargaJual * jumlah;
                
                totalHargaInput.value = total;
            }
        } else {
            totalHargaInput.value = 0;
        }
    }

    barangSelect.addEventListener('change', calculateTotal);
    jumlahInput.addEventListener('input', calculateTotal);
</script>
@endsection