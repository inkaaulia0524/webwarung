@extends('admin.layout')
@section('content')
<style>
    .report-container {
        background-color: var(--white);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .report-header h1 { margin: 0; font-size: 1.75rem; }

    /* 👇 1. TAMBAHKAN STYLE INI 👇 */
    .header-actions {
        display: flex;
        gap: 0.5rem;
    }
    .back-button {
        background-color: #236096ff; 
        color: var(--white);
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        font-family: "Crimson Pro", serif;
        font-size: 1rem;
    }
    .back-button:hover { background-color: #5a6268; }
    

    .action-button {
        background-color: #198754; 
        color: var(--white);
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        font-family: "Crimson Pro", serif;
        font-size: 1rem;
    }
    .action-button:hover { background-color: #157347; }
    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
    }
    .report-table th, .report-table td {
        border: 1px solid var(--border-color);
        padding: 0.75rem;
        text-align: left;
    }
    .report-table th { background-color: var(--bg-light); }
    .report-table td.text-right,
    .report-table th.text-right { text-align: right; }
    .report-total { text-align: right; }
    .report-total h3 { font-size: 1.25rem; }
    .report-total p {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
    }
</style>

<div class="report-container">
    
    <div class="report-header">
        <h1>Laporan Stok Barang</h1>
        <div class="header-actions">
            <a href="{{ route('laporan.index') }}" class="back-button">
                &larr; Kembali
            </a>
            <a href="{{ route('laporan.stok.export') }}" class="action-button">
                Export ke Excel
            </a>
        </div>
    </div>
    <table class="report-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th class="text-right">Stok</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Nilai Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($barangs as $index => $barang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barang->kode }}</td>
                    <td>{{ $barang->nama_barang }}</td>
                    <td class="text-right">{{ $barang->stok }}</td>
                    <td class="text-right">Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($barang->stok * $barang->harga_beli, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data barang.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="report-total">
        <h3>Total Nilai Stok (Stok x Harga Beli)</h3>
        <p>Rp {{ number_format($totalNilaiStok, 0, ',', '.') }}</p>
    </div>
</div>
@endsection