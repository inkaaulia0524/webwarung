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
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .report-header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .report-header-top h1 { margin: 0; font-size: 1.75rem; }
    .header-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
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
        display: inline-flex;
        align-items: center;
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
        display: inline-flex;
        align-items: center;
    }
    .action-button:hover { background-color: #157347; }
    
    .filter-form {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
        padding: 1rem;
        background-color: var(--bg-light);
        border-radius: 5px;
    }
    .filter-form label {
        font-weight: 600;
    }
    .filter-form input[type="date"] {
        padding: 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        font-family: "Crimson Pro", serif;
        font-size: 1rem;
    }
    .filter-form button {
        background-color: #0d6efd;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-family: "Crimson Pro", serif;
        font-size: 1rem;
    }
    .filter-form button:hover { background-color: #0b5ed7; }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .summary-card {
        background-color: var(--bg-light);
        border: 1px solid var(--border-color);
        padding: 1.5rem;
        border-radius: 8px;
    }
    .summary-card h3 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        color: #6c757d;
        font-weight: 600;
    }
    .summary-card p {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
    }
    .summary-card.pendapatan p { color: #198754; }
    .summary-card.hpp p { color: #dc3545; }
    .summary-card.laba p { color: #0d6efd; }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1.5rem;
        font-size: 0.95rem; 
    }
    .report-table th, .report-table td {
        border: 1px solid var(--border-color);
        padding: 0.75rem;
        text-align: left;
    }
    .report-table th { background-color: var(--bg-light); }
    .report-table td.text-right,
    .report-table th.text-right { text-align: right; }

    .report-table tfoot th {
        font-size: 1.1rem;
        font-weight: 700;
    }

</style>

<div class="report-container">
    
    <div class="report-header">
        <div class="report-header-top">
            <h1>Laporan Laba Rugi</h1>
            <div class="header-actions">
                <a href="{{ route('laporan.index') }}" class="back-button">
                    &larr; Kembali
                </a>
                <a href="{{ route('laporan.laba-rugi.export', ['tanggal_mulai' => $tanggalMulai, 'tanggal_akhir' => $tanggalAkhir]) }}" class="action-button">
                    Export ke Excel
                </a>
            </div>
        </div>

        <form method="GET" action="{{ route('laporan.laba-rugi') }}" class="filter-form">
            <div>
                <label for="tanggal_mulai">Dari Tanggal:</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ $tanggalMulai }}">
            </div>
            <div>
                <label for="tanggal_akhir">Sampai Tanggal:</label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
            </div>
            <button type="submit">Filter</button>
        </form>
    </div>

    <div class="summary-cards">
        <div class="summary-card pendapatan">
            <h3>Total Pendapatan</h3>
            <p>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card hpp">
            <h3>Total HPP (Modal)</h3>
            <p>Rp {{ number_format($totalHpp, 0, ',', '.') }}</p>
        </div>
        <div class="summary-card laba">
            <h3>Total Laba Kotor</h3>
            <p>Rp {{ number_format($totalLaba, 0, ',', '.') }}</p>
        </div>
    </div>

    <h2>Detail Penjualan per Item</h2>
    <table class="report-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Nama Barang</th>
                <th class="text-right">Jml</th>
                <th class="text-right">Pendapatan</th>
                <th class="text-right">HPP (Modal)</th>
                <th class="text-right">Laba</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualans as $penjualan)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($penjualan->tanggal)->format('d M Y, H:i') }}</td>
                    <td>{{ $penjualan->nama_pelanggan }}</td>
                    <td>{{ $penjualan->nama_barang }}</td>
                    <td class="text-right">{{ $penjualan->jumlah }}</td>
                    {{-- Menggunakan data yang dihitung di controller --}}
                    <td class="text-right">Rp {{ number_format($penjualan->pendapatan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($penjualan->hpp, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($penjualan->laba, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data penjualan pada rentang tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total Keseluruhan</th>
                <th class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($totalHpp, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($totalLaba, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

</div>
@endsection