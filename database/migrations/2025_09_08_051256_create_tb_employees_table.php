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
        Schema::create('tb_employees', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama pegawai/drafter
            $table->string('contact')->nullable(); // nomor HP/email pegawai
            $table->string('foto_paraf')->nullable(); // upload file ttd (foto/pdf)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_employees');
    }
};
