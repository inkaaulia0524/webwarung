<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HutangPiutang;
use Illuminate\Http\Request;

class HutangPiutangApiController extends Controller
{
    // GET list hutang /api/hutang
    public function index(Request $request)
    {
        $search = $request->search;

        $data = HutangPiutang::when($search, function ($query) use ($search) {
                $query->where('nama_pelanggan', 'like', "%{$search}%")
                      ->orWhere('nominal', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // GET single hutang /api/hutang/{id}
    public function show($id)
    {
        $hutang = HutangPiutang::find($id);

        if (!$hutang) {
            return response()->json([
                'success' => false,
                'message' => 'Data hutang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $hutang
        ]);
    }

    // POST create new hutang /api/hutang
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'nominal'        => 'required|numeric|min:1',
            'tanggal'        => 'required|date',
            'jatuh_tempo'    => 'nullable|date',
            'keterangan'     => 'nullable|string',
        ]);

        $validated['status'] = 'belum_lunas';

        $hutang = HutangPiutang::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hutang berhasil dicatat.',
            'data' => $hutang
        ], 201);
    }

    // PUT update hutang /api/hutang/{id}
    public function update(Request $request, $id)
    {
        $hutang = HutangPiutang::find($id);

        if (!$hutang) {
            return response()->json([
                'success' => false,
                'message' => 'Data hutang tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'nominal'        => 'required|numeric|min:1',
            'tanggal'        => 'required|date',
            'jatuh_tempo'    => 'nullable|date',
            'keterangan'     => 'nullable|string',
        ]);

        $hutang->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data hutang berhasil diperbarui.',
            'data' => $hutang
        ]);
    }

    // PATCH mark hutang as lunas /api/hutang/{id}/lunas
    public function selesai($id)
    {
        $hutang = HutangPiutang::find($id);

        if (!$hutang) {
            return response()->json([
                'success' => false,
                'message' => 'Data hutang tidak ditemukan'
            ], 404);
        }

        $hutang->update(['status' => 'lunas']);

        return response()->json([
            'success' => true,
            'message' => 'Hutang berhasil ditandai sebagai lunas.',
            'data' => $hutang
        ]);
    }

    // DELETE delete hutang /api/hutang/{id}
    public function destroy($id)
    {
        $hutang = HutangPiutang::find($id);

        if (!$hutang) {
            return response()->json([
                'success' => false,
                'message' => 'Data hutang tidak ditemukan'
            ], 404);
        }

        $hutang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data hutang berhasil dihapus.'
        ]);
    }
}
