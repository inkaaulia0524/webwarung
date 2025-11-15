<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class PenjualansController extends Controller
{
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

    public function create()
    {
        $barangs = Barang::all();
        return view('kasir.penjualan.create', compact('barangs'));
    }

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

    $barang = Barang::findOrFail($request->barang_id);

    if ($barang->stok < $request->jumlah) {
        return back()->withErrors(['jumlah' => 'Stok tidak mencukupi!'])->withInput();
    }

    Penjualan::create([
        'nama_pelanggan' => $request->nama_pelanggan,
        'nama_barang' => $barang->nama_barang,
        'jumlah' => $request->jumlah,
        'total_harga' => $request->total_harga,
        'via' => $request->via,
        'tanggal' => $request->tanggal,
    ]);

    $barang->stok -= $request->jumlah;
    $barang->save();

    return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil dan stok berkurang!');
    }

    public function edit(Penjualan $penjualan)
    {
        $barangs = \App\Models\Barang::all(); 
        return view('kasir.penjualan.edit', compact('penjualan', 'barangs'));
    }


    public function update(Request $request, Penjualan $penjualan)
    {
         $request->validate([
            'nama_pelanggan' => 'required',
            'barang_id' => 'required|exists:barangs,id', 
            'jumlah' => 'required|integer|min:1',
            'via' => 'required',
        ]);

        $barang = \App\Models\Barang::find($request->barang_id);

        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan!');
        }

        $total_harga = $barang->harga_jual * $request->jumlah;

        $barang->stok = $barang->stok - $request->jumlah;
        $barang->save();


        \App\Models\Penjualan::create([
            'nama_pelanggan'    => $request->nama_pelanggan,
            'nama_barang'       => $barang->nama_barang,
            'harga_beli_satuan' => $barang->harga_beli, 
            'jumlah'            => $request->jumlah,
            'total_harga'       => $total_harga, 
            'via'               => $request->via,
            'tanggal'           => now(),
        ]);

        return redirect()->route('kasir.index')->with('success', 'Transaksi berhasil disimpan!');
        }   

    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();
        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus!');
    }
}
