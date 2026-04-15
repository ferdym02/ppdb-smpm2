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
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pendaftaran');
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama');
            $table->string('alamat');
            $table->string('nama_ortu');
            $table->string('pekerjaan_ortu');
            $table->string('alamat_ortu');
            $table->string('asal_sekolah');
            $table->string('nomor_wa');
            $table->unsignedBigInteger('user_id');
            $table->string('ijazah')->nullable();
            $table->string('foto_calon_siswa')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->string('akte_kelahiran')->nullable();
            $table->text('catatan_penolakan')->nullable();
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('test_id')->nullable();
            $table->enum('status_tes', ['belum', 'sudah'])->default('belum');
            $table->unsignedInteger('nilai_tes_tertulis')->nullable();
            $table->unsignedInteger('nilai_tes_praktek')->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('status_pendaftaran')->default('pending');
            $table->enum('daftar_ulang', ['ya', 'tidak'])->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('periode_id')->references('id')->on('periodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
