<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Untuk lebar kolom otomatis

class StokExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Barang::orderBy('nama_barang', 'asc')->get();
    }

    
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kategori',
            'Stok',
            'Harga Beli (Rp)',
            'Harga Jual (Rp)',
            'Nilai Stok (Rp)',
        ];
    }

    public function map($barang): array
    {
        $nilaiStok = $barang->stok * $barang->harga_beli;

        return [
            $barang->kode,
            $barang->nama_barang,
            $barang->kategori,
            $barang->stok,
            (float) $barang->harga_beli, // Pastikan format angka
            (float) $barang->harga_jual, // Pastikan format angka
            (float) $nilaiStok,       // Pastikan format angka
        ];
    }
}