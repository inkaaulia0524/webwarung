@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-3">Dashboard</h1>

    @if(Auth::user()->role == 'admin')
        <p>Halo, <b>Admin</b> 👑</p>
        <a href="{{ route('barang.index') }}">Kelola Barang</a>
    @elseif(Auth::user()->role == 'kasir')
        <p>Halo, <b>Kasir</b> 💸</p>
        <a href="{{ route('barang.index') }}">Transaksi Penjualan</a>
    @elseif(Auth::user()->role == 'supplier')
        <p>Halo, <b>Supplier</b> 📦</p>
        <a href="{{ route('supplier.index') }}">Kelola Stok</a>
    @endif
</div>
@endsection
