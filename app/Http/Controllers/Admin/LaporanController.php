<?php

namespace App\Http\Controllers\Admin; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Penjualan; 
use App\Exports\StokExport;
use App\Exports\LabaRugiExport; 
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon; 

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function stok(Request $request)
    {
        $barangs = Barang::orderBy('nama_barang', 'asc')->get();
        $totalNilaiStok = $barangs->sum(function($barang) {
            return (float) $barang->harga_beli * (int) $barang->stok;
        });
        return view('admin.laporan.stok', compact('barangs', 'totalNilaiStok'));
    }

    public function stokExport()
    {
        $tanggal = date('Y-m-d');
        return Excel::download(new StokExport, 'laporan_stok_'. $tanggal .'.xlsx');
    }

    public function labaRugi(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->format('Y-m-d'));

        $startDate = Carbon::parse($tanggalMulai)->startOfDay();
        $endDate = Carbon::parse($tanggalAkhir)->endOfDay();

        $penjualans = Penjualan::whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalPendapatan = 0;
        $totalHpp = 0;
        $totalLaba = 0;

        foreach ($penjualans as $penjualan) {
            $pendapatan = (float) $penjualan->total_harga;
            
            $hpp = (float) $penjualan->harga_beli_satuan * (int) $penjualan->jumlah;
            
            $laba = $pendapatan - $hpp;

            $penjualan->pendapatan = $pendapatan;
            $penjualan->hpp = $hpp;
            $penjualan->laba = $laba;

            $totalPendapatan += $pendapatan;
            $totalHpp += $hpp;
            $totalLaba += $laba;
        }

        return view('admin.laporan.laba-rugi', compact(
            'penjualans', 
            'totalPendapatan', 
            'totalHpp', 
            'totalLaba', 
            'tanggalMulai', 
            'tanggalAkhir'
        ));
    }

    public function labaRugiExport(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $tanggalAkhir = $request->input('tanggal_akhir', Carbon::now()->format('Y-m-d'));
        
        $tanggal = date('Y-m-d');
        $namaFile = 'laporan_laba_rugi_' . $tanggalMulai . '_sampai_' . $tanggalAkhir . '.xlsx';

        return Excel::download(new LabaRugiExport($tanggalMulai, $tanggalAkhir), $namaFile);
    }
}