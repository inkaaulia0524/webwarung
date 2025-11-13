<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembelian;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    
    public function index(Request $request)
    {
        $range = $request->query('range', '7');
        $currentRange = $range; 

        $chartLabels = [];
        $chartBarangMasuk = [];
        $chartBarangKeluar = [];
        $dataMasukHarian = [];
        $dataKeluarHarian = [];

        $hariIni = Carbon::now()->endOfDay();

        if ($range == '30') {
            $tanggalMulai = Carbon::now()->subDays(29)->startOfDay();
            $jumlahHari = 30;
        } else if ($range == 'bulan_ini') {
            $tanggalMulai = Carbon::now()->startOfMonth();
            $jumlahHari = $tanggalMulai->diffInDays($hariIni) + 1;
        } else {
            $range = '7'; 
            $currentRange = '7';
            $tanggalMulai = Carbon::now()->subDays(6)->startOfDay();
            $jumlahHari = 7;
        }

        for ($i = 0; $i < $jumlahHari; $i++) {
            $tanggal = $tanggalMulai->copy()->addDays($i);
            
            $chartLabels[] = $tanggal->format('d M'); 
            
            $key = $tanggal->format('Y-m-d'); 
            
            $dataMasukHarian[$key] = 0;
            $dataKeluarHarian[$key] = 0;
        }

        $dataPembelian = Pembelian::whereBetween('tanggal_masuk', [$tanggalMulai, $hariIni])
            ->select(DB::raw('DATE(tanggal_masuk) as tanggal'), DB::raw('SUM(jumlah) as total'))
            ->groupBy('tanggal')
            ->get();
        
        $dataPengeluaran = Pengeluaran::whereBetween('tanggal', [$tanggalMulai, $hariIni])
            ->select(DB::raw('DATE(tanggal) as tanggal'), DB::raw('SUM(jumlah) as total'))
            ->groupBy('tanggal')
            ->get();

        foreach ($dataPembelian as $data) {
            if (isset($dataMasukHarian[$data->tanggal])) {
                $dataMasukHarian[$data->tanggal] = $data->total;
            }
        }
        foreach ($dataPengeluaran as $data) {
            if (isset($dataKeluarHarian[$data->tanggal])) {
                $dataKeluarHarian[$data->tanggal] = $data->total;
            }
        }

        $chartBarangMasuk = array_values($dataMasukHarian);
        $chartBarangKeluar = array_values($dataKeluarHarian);
        
        return view('admin.grafik.index', compact(
            'chartLabels',
            'chartBarangMasuk',
            'chartBarangKeluar',
            'currentRange' 
        ));
    }
}