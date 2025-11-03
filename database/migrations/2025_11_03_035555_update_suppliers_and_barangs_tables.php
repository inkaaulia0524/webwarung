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
        Schema::table('suppliers', function (Blueprint $table) {
            if (!Schema::hasColumn('suppliers', 'name')) {
                $table->string('name', 100)->after('id');
            }
            if (!Schema::hasColumn('suppliers', 'phone')) {
                $table->string('phone', 20)->nullable()->after('name');
            }
            if (!Schema::hasColumn('suppliers', 'address')) {
                $table->string('address', 255)->nullable()->after('phone');
            }
        });

        Schema::table('barangs', function (Blueprint $table) {
            if (!Schema::hasColumn('barangs', 'supplier_id')) {
                $table->foreignId('supplier_id')->nullable()
                      ->constrained('suppliers')
                      ->onDelete('set null')
                      ->after('harga_jual');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            if (Schema::hasColumn('suppliers', 'name')) $table->dropColumn('name');
            if (Schema::hasColumn('suppliers', 'phone')) $table->dropColumn('phone');
            if (Schema::hasColumn('suppliers', 'address')) $table->dropColumn('address');
        });

        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'supplier_id')) {
                $table->dropForeign(['supplier_id']);
                $table->dropColumn('supplier_id');
            }
        });
    }
};
