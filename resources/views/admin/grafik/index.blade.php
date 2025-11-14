@extends('admin.layout')
@section('content')
<style>
    
    .page-header {
        margin-bottom: 2rem;
    }
    .page-header h1 {
        font-size: 1.75rem;
        margin: 0;
    }
    .page-header p {
        margin-top: 0.25rem; 
        font-size: 1.1rem; 
        color: #666;
    }
    .chart-container {
        background-color: var(--white);
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        height: 60vh; 
    }

    
    .filter-wrapper {
        margin-bottom: 1rem;
        display: flex;
        gap: 0.5rem;
    }
    .filter-button {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-family: "Crimson Pro", serif;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary-color);
        background-color: var(--white);
        border: 1px solid var(--border-color);
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }
    .filter-button:hover {
        background-color: var(--bg-light);
    }
    .filter-button.active {
        background-color: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }
</style>

<div class="page-header">
    <h1>Grafik Barang Masuk dan Keluar</h1>
    <p>Data berdasarkan rentang waktu yang dipilih</p>
</div>

<div class="filter-wrapper">
    <a href="{{ route('grafik.index', ['range' => '7']) }}" 
       class="filter-button {{ $currentRange == '7' ? 'active' : '' }}">
       7 Hari Terakhir
    </a>
    <a href="{{ route('grafik.index', ['range' => '30']) }}" 
       class="filter-button {{ $currentRange == '30' ? 'active' : '' }}">
       30 Hari Terakhir
    </a>
    <a href="{{ route('grafik.index', ['range' => 'bulan_ini']) }}" 
       class="filter-button {{ $currentRange == 'bulan_ini' ? 'active' : '' }}">
       Bulan Ini
    </a>
</div>
<div class="chart-container">
    <canvas id="myChart"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels), 
            datasets: [
                {
                    label: 'Barang Masuk (Pembelian)',
                    data: @json($chartBarangMasuk),
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                },
                {
                    label: 'Barang Keluar (Pengeluaran)',
                    data: @json($chartBarangKeluar),
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.8)',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, 
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Jumlah: ' + context.parsed.y;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection