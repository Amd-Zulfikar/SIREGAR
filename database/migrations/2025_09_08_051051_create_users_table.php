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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama user
            $table->string('email')->unique(); // email unik, penting untuk login
            $table->string('password'); // password hash
            $table->foreignId('role_id')->constrained('tb_roles'); // FK ke tb_roles
            $table->string('email_verification_code')->nullable(); // kode verifikasi email
            $table->boolean('is_verified')->default(false); // status verifikasi
            $table->rememberToken(); // token remember me
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
