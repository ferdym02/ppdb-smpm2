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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade'); // periode_id dengan foreign key
            $table->date('tanggal_buka_tes'); // tanggal_buka_tes
            $table->date('tanggal_tutup_tes'); // tanggal_tutup_tes
            $table->integer('kuota_per_hari'); // kuota_per_hari
            $table->timestamps();
            $table->boolean('status')->default(false); // status dengan default 0 (false)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
