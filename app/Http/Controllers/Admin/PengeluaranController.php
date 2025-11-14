<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pengeluaran = Pengeluaran::with('barang')
            ->when($search, function ($query, $search) {
                $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%")
                      ->orWhere('kode', 'like', "%{$search}%");
                })
                ->orWhere('alasan', 'like', "%{$search}%");
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.pengeluaran.index', compact('pengeluaran', 'search'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('admin.pengeluaran.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'alasan'     => 'required|in:rusak,hilang,kadaluwarsa,internal,lainnya',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return back()
                ->withErrors(['jumlah' => 'Jumlah melebihi stok tersedia (stok sekarang: ' . $barang->stok . ').'])
                ->withInput();
        }

        Pengeluaran::create([
            'barang_id'  => $barang->id,
            'jumlah'     => $request->jumlah,
            'alasan'     => $request->alasan,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        $barang->decrement('stok', $request->jumlah);

        return redirect()
            ->route('pengeluaran.index')
            ->with('success', 'Pengeluaran barang berhasil dicatat dan stok telah diperbarui.');
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        $barangs = Barang::orderBy('nama_barang')->get();

        return view('admin.pengeluaran.edit', compact('pengeluaran', 'barangs'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'alasan'     => 'required|in:rusak,hilang,kadaluwarsa,internal,lainnya',
            'tanggal'    => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $oldBarang  = $pengeluaran->barang;
        $oldJumlah  = $pengeluaran->jumlah;

        if ($oldBarang) {
            $oldBarang->increment('stok', $oldJumlah);
        }
        
        $newBarang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $newBarang->stok) {
            if ($oldBarang) {
                $oldBarang->decrement('stok', $oldJumlah);
            }

            return back()
                ->withErrors(['jumlah' => 'Jumlah melebihi stok tersedia (stok sekarang: ' . $newBarang->stok . ').'])
                ->withInput();
        }

        $pengeluaran->update([
            'barang_id'  => $newBarang->id,
            'jumlah'     => $request->jumlah,
            'alasan'     => $request->alasan,
            'tanggal'    => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        $newBarang->decrement('stok', $request->jumlah);

        return redirect()
            ->route('pengeluaran.index')
            ->with('success', 'Data pengeluaran berhasil diperbarui dan stok telah disesuaikan.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->barang) {
            $pengeluaran->barang->increment('stok', $pengeluaran->jumlah);
        }

        $pengeluaran->delete();

        return redirect()
            ->route('pengeluaran.index')
            ->with('success', 'Data pengeluaran dihapus dan stok dikembalikan.');
    }
}
