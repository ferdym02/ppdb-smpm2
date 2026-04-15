<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ubah dulu data lama
        DB::table('pendaftars')->where('agama', 'islam')->update(['agama' => 'Islam']);
        DB::table('pendaftars')->where('agama', 'kristen protestan')->update(['agama' => 'Kristen Protestan']);
        DB::table('pendaftars')->where('agama', 'katolik')->update(['agama' => 'Katolik']);
        DB::table('pendaftars')->where('agama', 'hindu')->update(['agama' => 'Hindu']);
        DB::table('pendaftars')->where('agama', 'buddha')->update(['agama' => 'Buddha']);
        DB::table('pendaftars')->where('agama', 'khonghucu')->update(['agama' => 'Khonghucu']);

        // 2. Ubah ENUM jadi kapital
        DB::statement("
            ALTER TABLE pendaftars
            MODIFY agama ENUM(
                'Islam',
                'Kristen Protestan',
                'Katolik',
                'Hindu',
                'Buddha',
                'Khonghucu'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
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
};
