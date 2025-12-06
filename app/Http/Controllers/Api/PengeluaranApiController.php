<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\Barang;
use Illuminate\Http\Request;

class PengeluaranApiController extends Controller
{
    // GET all pengeluaran
    public function index()
    {
        $data = Pengeluaran::with('barang')
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // GET single pengeluaran
    public function show($id)
    {
        $pengeluaran = Pengeluaran::with('barang')->find($id);

        if (!$pengeluaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengeluaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pengeluaran
        ]);
    }

    // POST create new pengeluaran
    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'alasan'     => 'required|string',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Cek stok
        $barang = Barang::findOrFail($request->barang_id);
        if ($request->jumlah > $barang->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok tersedia'
            ], 400);
        }

        // Buat data + kurangi stok
        $pengeluaran = Pengeluaran::create($validated);
        $barang->decrement('stok', $request->jumlah);

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil dicatat',
            'data' => $pengeluaran
        ], 201);
    }

    // PUT update pengeluaran
    public function update(Request $request, $id)
    {
        $pengeluaran = Pengeluaran::find($id);

        if (!$pengeluaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'alasan'     => 'required|string',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Kembalikan stok lama
        $oldBarang = Barang::find($pengeluaran->barang_id);
        $oldBarang->increment('stok', $pengeluaran->jumlah);

        // Cek stok baru
        $newBarang = Barang::find($validated['barang_id']);
        if ($validated['jumlah'] > $newBarang->stok) {
            $oldBarang->decrement('stok', $pengeluaran->jumlah);

            return response()->json([
                'success' => false,
                'message' => 'Jumlah melebihi stok tersedia'
            ], 400);
        }

        // Update dan sesuaikan stok
        $pengeluaran->update($validated);
        $newBarang->decrement('stok', $validated['jumlah']);

        return response()->json([
            'success' => true,
            'message' => 'Data pengeluaran berhasil diperbarui',
            'data' => $pengeluaran
        ]);
    }

    // DELETE pengeluaran
    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        if (!$pengeluaran) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Kembalikan stok
        $barang = Barang::find($pengeluaran->barang_id);
        $barang->increment('stok', $pengeluaran->jumlah);

        $pengeluaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data pengeluaran berhasil dihapus'
        ]);
    }
}