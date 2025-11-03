@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Tambah Barang</h2>
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga Beli</label>
            <input type="number" step="0.01" name="harga_beli" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga Jual</label>
            <input type="number" step="0.01" name="harga_jual" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
