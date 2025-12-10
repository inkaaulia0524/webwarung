<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Pengeluaran;
use App\Models\Penjualan; // Pastikan model ini ada
use Illuminate\Support\Facades\DB;

class LaporanApiController extends Controller
{
    // 1. LAPORAN STOK (Sisa barang saat ini)
    public function stok()
    {
        // Ambil barang, urutkan dari stok yang paling sedikit (biar ketahuan mana yang mau habis)
        $stok = Barang::select('id', 'nama_barang', 'stok', 'harga_beli', 'harga_jual')
            ->orderBy('stok', 'asc')
            ->get();

        // Hitung total aset (Nilai uang yang mengendap di barang)
        $totalAset = $stok->sum(function($item) {
            return $item->stok * $item->harga_beli;
        });

        return response()->json([
            'success' => true,
            'message' => 'Data Laporan Stok Barang',
            'data' => [
                'total_aset_barang' => $totalAset, // Total duit di gudang
                'list_barang' => $stok
            ]
        ]);
    }

    // 2. LAPORAN LABA RUGI (Pemasukan vs Pengeluaran)
    public function labaRugi(Request $request)
    {
        // Default tanggal: Bulan ini full
        $tglAwal = $request->input('tgl_awal', date('Y-m-01'));
        $tglAkhir = $request->input('tgl_akhir', date('Y-m-d'));

        // A. HITUNG PEMASUKAN (Dari Penjualan)
        // Asumsi: Tabel penjualans punya kolom 'total_harga' atau 'bayar'
        // Jika belum ada model Penjualan, bagian ini akan error.
        $totalPenjualan = 0;
        if (class_exists(Penjualan::class)) {
            $totalPenjualan = Penjualan::whereDate('created_at', '>=', $tglAwal)
                ->whereDate('created_at', '<=', $tglAkhir)
                ->sum('total_harga'); // Sesuaikan 'total_harga' dengan nama kolom di tabelmu
        }

        // B. HITUNG PENGELUARAN 1 (Beli Stok Barang)
        $pembelian = Pembelian::whereDate('tanggal_masuk', '>=', $tglAwal)
            ->whereDate('tanggal_masuk', '<=', $tglAkhir)
            ->get();
        
        $totalBeliStok = $pembelian->sum(function($item) {
            return $item->jumlah * $item->harga_beli;
        });

        // C. HITUNG PENGELUARAN 2 (Operasional / Lain-lain)
        $totalOperasional = Pengeluaran::whereDate('tanggal', '>=', $tglAwal)
            ->whereDate('tanggal', '<=', $tglAkhir)
            ->sum('jumlah'); // Asumsi kolom 'jumlah' adalah nominal uang (Rp)

        // D. HITUNG BERSIH
        $totalPengeluaran = $totalBeliStok + $totalOperasional;
        $labaBersih = $totalPenjualan - $totalPengeluaran;

        return response()->json([
            'success' => true,
            'message' => "Laporan Laba Rugi ($tglAwal s/d $tglAkhir)",
            'data' => [
                'periode' => [
                    'start' => $tglAwal,
                    'end' => $tglAkhir
                ],
                'detail' => [
                    'pemasukan_penjualan' => (int) $totalPenjualan,
                    'pengeluaran_stok' => (int) $totalBeliStok,
                    'pengeluaran_operasional' => (int) $totalOperasional,
                ],
                'ringkasan' => [
                    'total_pendapatan' => (int) $totalPenjualan,
                    'total_beban' => (int) $totalPengeluaran,
                    'laba_bersih' => (int) $labaBersih, // Kalau minus berarti rugi
                    'status' => $labaBersih >= 0 ? 'UNTUNG' : 'RUGI'
                ]
            ]
        ]);
    }
}