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
            $table->foreignId('workspace_id')->constrained('tb_workspaces')->onDelete('cascade');
            $table->unsignedBigInteger('engine');
            $table->unsignedBigInteger('brand');
            $table->unsignedBigInteger('chassis');
            $table->unsignedBigInteger('vehicle');
            $table->unsignedBigInteger('keterangan');
            $table->json('foto_body');
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
