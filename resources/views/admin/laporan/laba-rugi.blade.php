@extends('admin.layout')
@section('content')
<style>
    .placeholder-container {
        background-color: var(--white);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        text-align: center;
    }
    .placeholder-container h1 { margin-top: 0; }
</style>

<div class="placeholder-container">
    <h1>Laporan Laba Rugi</h1>
    <p>Fitur ini sedang dalam tahap Perancangan.</p>
    <a href="{{ route('laporan.index') }}" style="text-decoration: none;">&larr; Kembali ke Pilihan Laporan</a>
</div>
@endsection