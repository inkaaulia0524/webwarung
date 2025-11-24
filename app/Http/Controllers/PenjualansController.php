<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\HutangPiutang; 
use Illuminate\Http\Request;

class PenjualansController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $penjualans = Penjualan::when($keyword, function ($query, $keyword) {
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
            'barang_id'      => 'required|exists:barangs,id',
            'jumlah'         => 'required|integer|min:1',
            'total_harga'    => 'required|numeric|min:0',
            'via'            => 'required',
            'tanggal'        => 'required|date',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok tidak mencukupi!'])
                         ->withInput();
        }

        // Simpan penjualan
        $penjualan = Penjualan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'nama_barang'    => $barang->nama_barang,
            'jumlah'         => $request->jumlah,
            'total_harga'    => $request->total_harga,
            'via'            => $request->via,
            'tanggal'        => $request->tanggal,
        ]);

        // Kurangi stok barang
        $barang->stok -= $request->jumlah;
        $barang->save();

        // Bila via = Hutang → masukkan data ke hutang_piutang
        if ($request->via === 'Hutang') {
            HutangPiutang::create([
                'penjualan_id'   => $penjualan->id,
                'nama_pelanggan' => $request->nama_pelanggan,
                'nominal'        => $request->total_harga,
                'tanggal'        => $request->tanggal,
                'jatuh_tempo'    => $request->jatuh_tempo,
                'keterangan'     => $request->keterangan,
            ]);
        }

        return redirect()->route('penjualan.index')
                         ->with('success', 'Penjualan berhasil disimpan!');
    }


    public function edit(Penjualan $penjualan)
    {
        $barangs = Barang::all();
        return view('kasir.penjualan.edit', compact('penjualan', 'barangs'));
    }


    public function update(Request $request, Penjualan $penjualan)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string',
            'barang_id'      => 'required|exists:barangs,id',
            'jumlah'         => 'required|integer|min:1',
            'via'            => 'required',
            'tanggal'        => 'required|date',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        // Hitung total harga baru
        $total_harga = $request->jumlah * $barang->harga_jual;

        // Update stok barang (kembalikan stok lama → kurangi stok baru)
        $barang->stok += $penjualan->jumlah; // kembalikan stok lama dulu
        $barang->stok -= $request->jumlah;   // kurangi stok baru
        $barang->save();

        // Update data penjualan
        $penjualan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'nama_barang'    => $barang->nama_barang,
            'jumlah'         => $request->jumlah,
            'total_harga'    => $total_harga,
            'via'            => $request->via,
            'tanggal'        => $request->tanggal,
            'barang_id'      => $request->barang_id,
        ]);

        // Update hutang jika via = Hutang
        if ($request->via === "Hutang") {
            $penjualan->hutang()->updateOrCreate(
                ['penjualan_id' => $penjualan->id],
                [
                    'nama_pelanggan' => $request->nama_pelanggan,
                    'nominal'        => $total_harga,
                    'tanggal'        => $request->tanggal,
                    'jatuh_tempo'    => $request->jatuh_tempo,
                    'keterangan'     => $request->keterangan,
                ]
            );
        } else {
            // Jika bukan hutang → hapus hutangnya
            $penjualan->hutang()->delete();
        }

        return redirect()->route('penjualan.index')
                         ->with('success', 'Penjualan berhasil diupdate!');
    }


    public function destroy(Penjualan $penjualan)
    {
        // Kembalikan stok barang dulu
        $barang = Barang::find($penjualan->barang_id);
        if ($barang) {
            $barang->stok += $penjualan->jumlah;
            $barang->save();
        }

        // Hapus hutang jika ada
        $penjualan->hutang()->delete();

        $penjualan->delete();

        return redirect()->route('penjualan.index')
                         ->with('success', 'Data penjualan berhasil dihapus!');
    }
}
