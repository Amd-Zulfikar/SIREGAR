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
        Schema::create('tb_workspace', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi')->unique(); // Nomor transaksi otomatis
            $table->foreignId('customer_id')->constrained('tb_customers')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('tb_employees')->onDelete('cascade');
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_workspace');
    }
};
