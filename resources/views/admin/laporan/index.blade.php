@extends('admin.layout')
@section('content')
<style>
    .page-header h1 { font-size: 1.75rem; margin: 0; }
    .report-selection {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    .report-card {
        background-color: var(--white);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        text-decoration: none;
        color: var(--text-dark);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    .report-card h2 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        color: var(--primary-color);
        font-size: 1.5rem;
    }
    .report-card p { margin: 0; color: #666; font-size: 1rem; }
    .coming-soon {
        background-color: #ffc107;
        color: #333;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
    }
</style>

<div class="page-header" style="margin-bottom: 2rem;">
    <h1>Pilih Laporan</h1>
</div>

<div class="report-selection">
    <a href="{{ route('laporan.stok') }}" class="report-card">
        <h2>📄 Laporan Stok</h2>
        <p>Melihat jumlah dan nilai total stok barang saat ini.</p>
    </a>

    <a href="{{ route('laporan.laba-rugi') }}" class="report-card">
        <h2>💰 Laporan Laba Rugi</h2>
        <p>Menganalisis pendapatan dan pengeluaran.</p>
    </a>
</div>
@endsection