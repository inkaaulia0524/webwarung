<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 1. Tambahkan 'use' ini
use App\Models\Barang;
use App\Exports\StokExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Tampilkan halaman pilihan laporan (hub)
     */
    public function index()
    {
        // 2. Arahkan ke view 'index'
        return view('admin.laporan.index');
    }

    /**
     * Tampilkan halaman laporan stok
     */
    public function stok(Request $request)
    {
        // 3. Ambil data untuk laporan stok
        $barangs = Barang::orderBy('nama_barang', 'asc')->get();

        $totalNilaiStok = $barangs->sum(function($barang) {
            return (float) $barang->harga_beli * (int) $barang->stok;
        });

        // 4. Arahkan ke view 'stok'
        return view('admin.laporan.stok', compact('barangs', 'totalNilaiStok'));
    }

    /**
     * Handle export data stok ke Excel
     */
    public function stokExport()
    {
        // 5. Panggil class StokExport yang sudah kita buat
        $tanggal = date('Y-m-d');
        return Excel::download(new StokExport, 'laporan_stok_'. $tanggal .'.xlsx');
    }

    /**
     * Tampilkan halaman laba rugi (placeholder)
     */
    public function labaRugi(Request $request)
    {
        // 6. Arahkan ke view 'laba-rugi'
        return view('admin.laporan.laba-rugi');
    }
}