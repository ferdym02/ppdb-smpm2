<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah kolom agama jadi ENUM
        DB::statement("
            ALTER TABLE pendaftars
            MODIFY agama ENUM(
                'islam',
                'kristen protestan',
                'katolik',
                'hindu',
                'buddha',
                'khonghucu'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        // Balikkan ke string kalau rollback
        Schema::table('pendaftars', function (Blueprint $table) {
            $table->string('agama')->change();
        });
    }
};
