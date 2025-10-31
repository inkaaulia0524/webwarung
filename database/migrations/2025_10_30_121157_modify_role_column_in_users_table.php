<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom role lama karna tipe nya berbeda
            $table->dropColumn('role');
        });

        Schema::table('users', function (Blueprint $table) {
            // Tambahkan ulang dengan tipe enum sesuai dengan praktikum
            $table->enum('role', ['kasir', 'admin'])->default('kasir');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->string('role')->default('kasir');
        });
    }
};