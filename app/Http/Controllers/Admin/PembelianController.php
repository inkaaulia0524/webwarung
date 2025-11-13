<?php

namespace App\Http\Controllers\admin;

use App\Models\Pembelian;
use App\Models\Barang;    
use App\Models\Supplier; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pembelians = Pembelian::with(['barang', 'supplier']) 
            ->when($search, function ($query, $search) {
                return $query->whereHas('barang', function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                })->orWhereHas('supplier', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
            })
            ->latest() 
            ->paginate(10);

        return view('admin.pembelian.index', compact('pembelians', 'search'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        return view('admin.pembelian.create', compact('barangs', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $barang = Barang::find($validatedData['barang_id']);

        $validatedData['harga'] = $barang->harga_beli;
        $pembelian = Pembelian::create($validatedData);

        $barang->stok = $barang->stok + $pembelian->jumlah;
        $barang->save();

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan dan stok diperbarui');
    }

    public function edit(Pembelian $pembelian)
    {
        $barangs = Barang::all();
        $suppliers = Supplier::all();
        return view('admin.pembelian.edit', compact('pembelian', 'barangs', 'suppliers'));
    }

    public function update(Request $request, Pembelian $pembelian)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
        ]);

        $jumlahLama = $pembelian->jumlah;
        $barang = Barang::find($pembelian->barang_id);

        $barang->stok = $barang->stok - $jumlahLama;
        
        $pembelian->update($request->all());

        $barang->stok = $barang->stok + $pembelian->jumlah;
        $barang->save();

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil diperbarui dan stok dikalkulasi ulang');
    }

    public function destroy(Pembelian $pembelian)
    {

        $barang = Barang::find($pembelian->barang_id);

        $barang->stok = $barang->stok - $pembelian->jumlah;
        $barang->save();

        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil dihapus dan stok diperbarui');
    }
}