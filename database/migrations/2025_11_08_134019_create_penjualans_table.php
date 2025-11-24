<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->decimal('total_harga', 12, 2);
            $table->enum('via', ['Tunai', 'QRIS', 'Transfer', 'Hutang']);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
