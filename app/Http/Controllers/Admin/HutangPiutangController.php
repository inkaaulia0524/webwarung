<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\HutangPiutang;
use Illuminate\Http\Request;

class HutangPiutangController extends Controller
{
    // INDEX: Tampilkan daftar hutang
    public function index(Request $request)
    {
        $search = $request->input('search');

        $hutang = HutangPiutang::when($search, function($query, $search) {
                $query->where('nama_pelanggan', 'like', "%{$search}%")
                      ->orWhere('nominal', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('admin.hutangpiutang.index', compact('hutang', 'search'));
    }

    // EDIT: kasir/admin ubah data hutang
    public function edit($id)
    {
        $hutang = HutangPiutang::findOrFail($id);
        return view('admin.hutangpiutang.edit', compact('hutang'));
    }

    // UPDATE hutang
    public function update(Request $request, $id)
    {
        $hutang = HutangPiutang::findOrFail($id);

        $hutang->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'nominal'        => $request->nominal,
            'tanggal'        => $request->tanggal,
            'jatuh_tempo'    => $request->jatuh_tempo,
            'keterangan'     => $request->keterangan,
        ]);

        return redirect()->route('hutangpiutang.index')->with('success', 'Hutang berhasil diperbarui.');
    }

    // SELESAI BAYAR = status lunas
    public function selesai($id)
    {
        $hutang = HutangPiutang::findOrFail($id);
        $hutang->update(['status' => 'lunas']); // Tidak hapus penjualan, hanya update hutang

        return redirect()->route('hutangpiutang.index')->with('success', 'Hutang sudah ditandai sebagai lunas!');
    }

    public function destroy($id)
    {
    $hutang = HutangPiutang::findOrFail($id);
    $hutang->delete();

    return redirect()->route('hutangpiutang.index')
                     ->with('success', 'Hutang berhasil dihapus / ditandai selesai!');
    }

}
