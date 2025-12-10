<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GrafikApiController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dari request, kalau tidak ada pakai tahun sekarang
        $tahun = $request->input('tahun', date('Y'));

        // Siapkan array kosong untuk 12 bulan (Jan - Des)
        $dataPembelian = [];
        $dataPengeluaran = [];
        $labels = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 
            'Jul', 'Agust', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        // Looping bulan 1 sampai 12
        for ($bulan = 1; $bulan <= 12; $bulan++) {
            
            // Hitung Total Item Masuk (Pembelian) per bulan
            $totalBeli = Pembelian::whereYear('tanggal_masuk', $tahun)
                ->whereMonth('tanggal_masuk', $bulan)
                ->sum('jumlah');

            // Hitung Total Item Keluar (Pengeluaran) per bulan
            $totalKeluar = Pengeluaran::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->sum('jumlah');

            // Masukkan ke array (index array mulai dari 0, jadi bulan-1)
            $dataPembelian[] = (int) $totalBeli;
            $dataPengeluaran[] = (int) $totalKeluar;
        }

        return response()->json([
            'success' => true,
            'message' => "Data Grafik Tahun $tahun",
            'data' => [
                'tahun' => $tahun,
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Barang Masuk',
                        'data' => $dataPembelian,
                        'color' => 'blue' // Info warna buat frontend (opsional)
                    ],
                    [
                        'label' => 'Barang Keluar',
                        'data' => $dataPengeluaran,
                        'color' => 'red'
                    ]
                ]
            ]
        ]);
    }
}