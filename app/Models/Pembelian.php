<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'pembelians';
    protected $fillable = [
        'barang_id',
        'supplier_id',
        'jumlah',
        'tanggal_masuk',
        'harga', 
    ];
    protected $casts = [
        'tanggal_masuk' => 'date',
    ];
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}