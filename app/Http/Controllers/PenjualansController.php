<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualansController extends Controller
{
    /**
     * Tampilkan daftar penjualan (dengan fitur pencarian)
     */
public function index(Request $request)
{
    $keyword = $request->input('search');

    $penjualans = \App\Models\Penjualan::when($keyword, function ($query, $keyword) {
        $query->where('nama_pelanggan', 'like', "%{$keyword}%")
              ->orWhere('nama_barang', 'like', "%{$keyword}%")
              ->orWhere('via', 'like', "%{$keyword}%");
    })
    ->orderBy('tanggal', 'desc')
    ->paginate(10);

    return view('kasir.penjualan.index', compact('penjualans', 'keyword'));
}

    /**
     * Form tambah data penjualan
     */
    public function create()
{
    $barangs = Barang::all();
    return view('kasir.penjualan.create', compact('barangs'));
}


    /**
     * Simpan data baru ke database
     */
public function store(Request $request)
{
    $request->validate([
        'nama_pelanggan' => 'required|string|max:255',
        'barang_id' => 'required|exists:barangs,id',
        'jumlah' => 'required|integer|min:1',
        'total_harga' => 'required|numeric|min:0',
        'via' => 'required',
        'tanggal' => 'required|date',
    ]);

    // Ambil data barang
    $barang = Barang::findOrFail($request->barang_id);

    // Cek apakah stok cukup
    if ($barang->stok < $request->jumlah) {
        return back()->withErrors(['jumlah' => 'Stok tidak mencukupi!'])->withInput();
    }

    // Simpan penjualan
    Penjualan::create([
        'nama_pelanggan' => $request->nama_pelanggan,
        'nama_barang' => $barang->nama_barang,
        'jumlah' => $request->jumlah,
        'total_harga' => $request->total_harga,
        'via' => $request->via,
        'tanggal' => $request->tanggal,
    ]);

    // Kurangi stok
    $barang->stok -= $request->jumlah;
    $barang->save();

    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dan stok berkurang!');
}

    /**
     * Form edit data penjualan
     */
public function edit(Penjualan $penjualan)
{
    $barangs = \App\Models\Barang::all(); // ambil semua data barang untuk dropdown
    return view('kasir.penjualan.edit', compact('penjualan', 'barangs'));
}


    /**
     * Update data penjualan yang ada
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|numeric|min:0',
            'via' => 'required',
            'tanggal' => 'required|date',
        ]);

        $penjualan->update($request->all());
        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil diperbarui!');
    }

    /**
     * Hapus data penjualan
     */
    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus!');
    }
}
