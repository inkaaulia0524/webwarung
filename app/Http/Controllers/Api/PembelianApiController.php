<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Barang;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianApiController extends Controller
{
    // GET: Ambil semua data pembelian (dengan search & pagination)
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pembelians = Pembelian::with(['barang', 'supplier'])
            ->when($search, function ($query, $search) {
                 // ... logic search biarkan saja ...
            })
            ->latest()
            ->get(); // <--- GANTI DARI paginate(10) KE get()

        return response()->json([
            'success' => true,
            'message' => 'Daftar Data Pembelian',
            'data'    => $pembelians // Sekarang ini adalah Array List murni
        ]);
    }

    // POST: Simpan pembelian baru
    public function store(Request $request)
    {
        // Validasi
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        // Logic Stok (Sama persis dengan versi Web)
        $barang = Barang::find($validatedData['barang_id']);
        $validatedData['harga'] = $barang->harga_beli;

        $pembelian = Pembelian::create($validatedData);

        // Tambah stok barang
        $barang->stok = $barang->stok + $pembelian->jumlah;
        $barang->save();

        return response()->json([
            'success' => true,
            'message' => 'Pembelian berhasil ditambahkan dan stok diperbarui',
            'data'    => $pembelian
        ], 201);
    }

    // GET: Ambil detail 1 pembelian (untuk form edit di frontend)
    public function show($id)
    {
        $pembelian = Pembelian::with(['barang', 'supplier'])->find($id);

        if (!$pembelian) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pembelian
        ]);
    }

    // PUT/PATCH: Update data pembelian
    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::find($id);

        if (!$pembelian) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        // Logic Re-kalkulasi Stok (Sama persis dengan versi Web)
        $jumlahLama = $pembelian->jumlah;
        $barang = Barang::find($pembelian->barang_id);

        // Kembalikan stok lama dulu
        $barang->stok = $barang->stok - $jumlahLama;

        // Update data transaksi
        $pembelian->update($request->all());

        // Tambahkan stok baru
        $barang->stok = $barang->stok + $pembelian->jumlah;
        $barang->save();

        return response()->json([
            'success' => true,
            'message' => 'Pembelian berhasil diperbarui dan stok dikalkulasi ulang',
            'data'    => $pembelian
        ]);
    }

    // DELETE: Hapus data pembelian
    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);

        if (!$pembelian) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        $barang = Barang::find($pembelian->barang_id);

        // Kurangi stok karena transaksi dibatalkan/dihapus
        $barang->stok = $barang->stok - $pembelian->jumlah;
        $barang->save();

        $pembelian->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pembelian berhasil dihapus dan stok diperbarui'
        ]);
    }
}