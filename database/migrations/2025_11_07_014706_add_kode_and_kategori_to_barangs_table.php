<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
        Schema::table('barangs', function (Blueprint $table) {
            $table->string('kode')->unique()->after('id');  
            $table->string('kategori')->nullable()->after('nama_barang'); 
    });
}

    public function down(){
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropColumn(['kode', 'kategori']);
        });
    }
};
