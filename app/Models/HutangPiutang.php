<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HutangPiutang extends Model
{
    protected $fillable = [
        'penjualan_id',
        'nama_pelanggan',
        'nominal',
        'tanggal',
        'jatuh_tempo',
        'keterangan',
        'status',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
