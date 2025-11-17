<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Barang;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sekarang = Carbon::now();
        $bulanIni = $sekarang->month;
        $tahunIni = $sekarang->year;

        // TOTAL BARANG (pakai stok)
        $totalBarang = Barang::sum('stok');

        // TOTAL SUPPLIER
        $totalSupplier = Supplier::count();

        // BARANG MASUK BULAN INI
        $barangMasukBulanIni = Pembelian::whereMonth('tanggal_masuk', $bulanIni)
                                        ->whereYear('tanggal_masuk', $tahunIni)
                                        ->sum('jumlah');

        // BARANG KELUAR BULAN INI
        $barangKeluarBulanIni = Pengeluaran::whereMonth('tanggal', $bulanIni)
                                          ->whereYear('tanggal', $tahunIni)
                                          ->sum('jumlah');

        // --- GRAFIK ---
        $chartLabels = [];
        $chartBarangMasuk = [];
        $chartBarangKeluar = [];

        $tujuhHariLalu = Carbon::now()->subDays(6)->startOfDay();
        $hariIni = Carbon::now()->endOfDay();

        $dataMasukHarian = [];
        $dataKeluarHarian = [];

        // Generate label tanggal dari 7 hari terakhir
        for ($i = 0; $i <= 6; $i++) {
            $tanggal = $tujuhHariLalu->copy()->addDays($i);
            $chartLabels[] = $tanggal->format('d M');
            $key = $tanggal->format('Y-m-d');

            $dataMasukHarian[$key] = 0;
            $dataKeluarHarian[$key] = 0;
        }

        // DATA PEMBELIAN (barang masuk)
        $dataPembelian = Pembelian::whereBetween('tanggal_masuk', [$tujuhHariLalu, $hariIni])
            ->select(
                DB::raw('DATE(tanggal_masuk) as tanggal'),
                DB::raw('SUM(jumlah) as total')
            )
            ->groupBy('tanggal')
            ->get();

        // DATA PENGELUARAN (barang keluar)
        $dataPengeluaran = Pengeluaran::whereBetween('tanggal', [$tujuhHariLalu, $hariIni])
            ->select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(jumlah) as total')
            )
            ->groupBy('tanggal')
            ->get();

        foreach ($dataPembelian as $data) {
            $dataMasukHarian[$data->tanggal] = $data->total;
        }
        foreach ($dataPengeluaran as $data) {
            $dataKeluarHarian[$data->tanggal] = $data->total;
        }

        $chartBarangMasuk = array_values($dataMasukHarian);
        $chartBarangKeluar = array_values($dataKeluarHarian);

        return view('kasir.dashboard', compact(
            'totalBarang',
            'barangMasukBulanIni',
            'barangKeluarBulanIni',
            'totalSupplier',
            'chartLabels',
            'chartBarangMasuk',
            'chartBarangKeluar'
        ));
    }
}
