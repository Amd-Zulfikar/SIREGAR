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
        Schema::table('tb_mdata', function (Blueprint $table) {

            // --- LANGKAH 1: HAPUS UNIQUE INDEX YANG SALAH PADA engine_id ---

            // Mencoba menghapus unique index default Laravel (jika ada)
            $indexRemoved = false;
            try {
                $table->dropUnique('tb_mdata_engine_id_unique');
                $indexRemoved = true;
            } catch (\Exception $e) {
                // Lanjutkan jika nama index default tidak ditemukan
            }

            // Mencoba menghapus unique index dengan nama yang muncul di error Anda (engine_id_UNIQUE)
            if (!$indexRemoved) {
                try {
                    $table->dropUnique('engine_id_UNIQUE');
                    $indexRemoved = true;
                } catch (\Exception $e) {
                    // Lanjutkan jika nama index dari error juga tidak ditemukan
                }
            }


            // --- LANGKAH 2: TAMBAHKAN UNIQUE INDEX KOMPOSIT PADA 4 KOLOM ---

            // Sekarang, batasan unik hanya berlaku jika keempat kolom SAMA PERSIS.
            $table->unique(
                ['engine_id', 'brand_id', 'chassis_id', 'vehicle_id'],
                'mdata_unique_combination' // Beri nama index komposit yang jelas
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_mdata', function (Blueprint $table) {
            // Hapus index unique komposit jika migrasi di-rollback
            $table->dropUnique('mdata_unique_combination');
        });
    }
};
