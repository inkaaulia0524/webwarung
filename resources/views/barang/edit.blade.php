@extends('admin.layout')

@section('content')
<div class="container">
    <h2>Edit Barang</h2>
    <form action="{{ route('barang.update', $barang->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" value="{{ $barang->nama_barang }}" required>
        </div>
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ $barang->stok }}" required>
        </div>
        <div class="mb-3">
            <label>Harga Beli</label>
            <input type="number" step="0.01" name="harga_beli" class="form-control" value="{{ $barang->harga_beli }}" required>
        </div>
        <div class="mb-3">
            <label>Harga Jual</label>
            <input type="number" step="0.01" name="harga_jual" class="form-control" value="{{ $barang->harga_jual }}" required>
        </div>
        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
