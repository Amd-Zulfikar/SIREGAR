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
        Schema::create('tb_workspace_gambar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('tb_workspace')->onDelete('cascade');
            $table->foreignId('mgambar_id')->constrained('tb_mgambar')->onDelete('cascade');
            $table->integer('no_halaman');
            $table->integer('jumlah_gambar');
            $table->string('file_path')->nullable(); // Hasil overlay foto_body
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_workspace_gambar');
    }
};
