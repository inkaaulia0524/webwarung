@extends('admin.layout')
@section('content')

    <style>
        .header-dashboard {
            margin-bottom: 2rem;
        }

        .header-dashboard h1 {
            font-size: 1.75rem; 
            margin: 0;
            color: var(--text-dark);
        }

        .header-dashboard p {
            font-size: 1.1rem;
            color: #666;
            margin-top: 0.25rem;
        }
        
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr); 
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background-color: var(--white);
            padding: 1.25rem; 
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .stat-card h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1rem;
            color: #555;
            text-transform: uppercase;
        }
        
        .stat-card .stat-value {
            font-size: 2.25rem; 
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0; 
        }
        
        .chart-container {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            height: 400px; 
        }
    </style>

    <div class="header-dashboard">
        <h1>Halo, {{ Auth::user()->name ?? 'Admin' }}! 👋</h1>
        <p>Selamat datang di Dashboard {{ ucfirst(Auth::user()->role ?? 'Admin') }}.</p>
    </div>

    <div class="stat-cards">
        <div class="stat-card">
            <h3>Total Barang</h3>
            <p class="stat-value">{{ number_format($totalBarang) }}</p>
        </div>
        <div class="stat-card">
            <h3>Barang Masuk (Bulan Ini)</h3>
            <p class="stat-value">{{ number_format($barangMasukBulanIni) }}</p>
        </div>
        <div class="stat-card">
            <h3>Barang Keluar (Bulan Ini)</h3>
            <p class="stat-value">{{ number_format($barangKeluarBulanIni) }}</p>
        </div>
        <div class="stat-card">
            <h3>Total Supplier</h3>
            <p class="stat-value">{{ number_format($totalSupplier) }}</p>
        </div>
    </div>

    <div class="chart-container">
        <h2>Grafik Barang Masuk dan Keluar (7 Hari Terakhir)</h2>
        
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
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.1
                },
                {
                    label: 'Barang Keluar (Pengeluaran)',
                    data: @json($chartBarangKeluar),
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.1
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