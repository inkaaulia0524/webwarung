<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'nama_barang',
        'harga_beli_satuan',
        'jumlah',
        'total_harga',
        'via',
        'tanggal',
        'barang_id',
    ];
    public function hutang()
    {
    return $this->hasOne(HutangPiutang::class);
}

}

