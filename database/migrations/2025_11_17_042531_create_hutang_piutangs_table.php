<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hutang_piutangs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('penjualan_id'); 
        $table->string('nama_pelanggan');
        $table->integer('nominal');
        $table->date('tanggal');
        $table->date('jatuh_tempo')->nullable();
        $table->string('keterangan')->nullable();
        $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
        $table->timestamps();

        $table->foreign('penjualan_id')->references('id')->on('penjualans')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hutang_piutangs');
    }
};
