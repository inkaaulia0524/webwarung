@extends('kasir.layout')
@section('content')

    <style>

        .header-dashboard {
            margin-bottom: 2rem;
        }

        .header-dashboard h1 {
            font-size: 2.25rem;
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

            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background-color: var(--white);
            padding: 1.5rem;
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
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .chart-container {
            background-color: var(--white);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

    </style>

    <div class="header-dashboard">
        {{-- Sapaan "Halo" dengan nama dan role --}}
        <h1>Halo, {{ Auth::user()->name ?? 'Admin' }}! 👋</h1>
        <p>Selamat datang di Dashboard {{ ucfirst(Auth::user()->role ?? 'Admin') }}.</p>
    </div>

    <div class="stat-cards">
        <div class="stat-card">
            <h3>Total Barang</h3>
            <p class="stat-value">1,240</p>
        </div>
        <div class="stat-card">
            <h3>Barang Masuk (Bulan Ini)</h3>
            <p class="stat-value">312</p>
        </div>
        <div class="stat-card">
            <h3>Barang Keluar (Bulan Ini)</h3>
            <p class="stat-value">280</p>
        </div>
        <div class="stat-card">
            <h3>Total Supplier</h3>
            <p class="stat-value">45</p>
        </div>
    </div>

    <div class="chart-container">
        <h2>Grafik Barang Masuk vs Keluar</h2>
        <p>Di sini Anda bisa meletakkan chart (misalnya menggunakan Chart.js).</p>
            </div>

@endsection