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
        Schema::create('profil_sekolahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah', 255); // Nama sekolah
            $table->unsignedBigInteger('npsn');
            $table->text('alamat_sekolah'); // Alamat sekolah
            $table->string('email_sekolah', 255); // Email sekolah
            $table->string('telepon_sekolah', 255); // Telepon sekolah
            $table->string('logo_sekolah', 255); // Logo sekolah (opsional)
            $table->string('call_center')->nullable();
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_sekolahs');
    }
};
