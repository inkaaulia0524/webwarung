<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardApiController extends Controller
{
    public function index()
    {
        $sekarang = Carbon::now();
        $bulanIni = $sekarang->month;
        $tahunIni = $sekarang->year;

        // 1. Data Card Statistik
        $totalBarang = Barang::sum('stok');
        $totalSupplier = Supplier::count();

        $barangMasukBulanIni = Pembelian::whereMonth('tanggal_masuk', $bulanIni)
            ->whereYear('tanggal_masuk', $tahunIni)
            ->sum('jumlah');

        $barangKeluarBulanIni = Pengeluaran::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->sum('jumlah');

        // 2. Data Chart (7 Hari Terakhir)
        $chartLabels = [];
        $tujuhHariLalu = Carbon::now()->subDays(6)->startOfDay();
        $hariIni = Carbon::now()->endOfDay();

        $dataMasukHarian = [];
        $dataKeluarHarian = [];

        // Loop untuk inisialisasi array 7 hari ke belakang (biar tidak bolong tanggalnya)
        for ($i = 0; $i <= 6; $i++) {
            $tanggal = $tujuhHariLalu->copy()->addDays($i);
            
            // Format Label untuk Frontend (misal: "10 Dec")
            $chartLabels[] = $tanggal->format('d M'); 
            
            // Key untuk pencocokan data database
            $key = $tanggal->format('Y-m-d'); 
            
            $dataMasukHarian[$key] = 0;
            $dataKeluarHarian[$key] = 0;
        }

        // Query Database Pembelian
        $dataPembelian = Pembelian::whereBetween('tanggal_masuk', [$tujuhHariLalu, $hariIni])
            ->select(
                DB::raw('DATE(tanggal_masuk) as tanggal'), 
                DB::raw('SUM(jumlah) as total')
            )
            ->groupBy('tanggal')
            ->get();
        
        // Query Database Pengeluaran
        $dataPengeluaran = Pengeluaran::whereBetween('tanggal', [$tujuhHariLalu, $hariIni])
            ->select(
                DB::raw('DATE(tanggal) as tanggal'), 
                DB::raw('SUM(jumlah) as total')
            )
            ->groupBy('tanggal')
            ->get();

        // Masukkan data DB ke Array Harian
        foreach ($dataPembelian as $data) {
            $dataMasukHarian[$data->tanggal] = $data->total;
        }
        foreach ($dataPengeluaran as $data) {
            $dataKeluarHarian[$data->tanggal] = $data->total;
        }

        // Ubah jadi array index (angka saja) untuk dikirim ke chart
        $chartBarangMasuk = array_values($dataMasukHarian);
        $chartBarangKeluar = array_values($dataKeluarHarian);

        // Return JSON
        return response()->json([
            'success' => true,
            'data' => [
                'statistik' => [
                    'total_stok_barang' => $totalBarang,
                    'total_supplier' => $totalSupplier,
                    'barang_masuk_bulan_ini' => $barangMasukBulanIni,
                    'barang_keluar_bulan_ini' => $barangKeluarBulanIni,
                ],
                'grafik' => [
                    'labels' => $chartLabels,
                    'data_masuk' => $chartBarangMasuk,
                    'data_keluar' => $chartBarangKeluar
                ]
            ]
        ]);
    }
}