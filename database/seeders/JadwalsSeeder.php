<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwals')->insert([
            [
                // hapus semua id dan timestamp
                'kegiatan' => 'Pendaftaran dan Verifikasi',
                'lokasi' => 'Online',
                'tanggal_mulai' => '2026-06-19',
                'tanggal_selesai' => '2026-06-24',
                'waktu' => '07.30 - 15.00 WIB',
            ],
            [
                'kegiatan' => 'Tes Tertulis & Praktek',
                'lokasi' => 'Di Sekolah',
                'tanggal_mulai' => '2026-06-19',
                'tanggal_selesai' => '2026-06-25',
                'waktu' => '07.30 - 15.00 WIB',
            ],
            [
                'kegiatan' => 'Pengumuman',
                'lokasi' => 'Online',
                'tanggal_mulai' => '2026-06-29',
                'tanggal_selesai' => null,
                'waktu' => '-',
            ],
            [
                'kegiatan' => 'Daftar Ulang',
                'lokasi' => 'Di Sekolah',
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2026-07-02',
                'waktu' => '09.00 - 15.00 WIB',
            ],
            [
                'kegiatan' => 'MPLS',
                'lokasi' => 'Di Sekolah',
                'tanggal_mulai' => '2026-07-15',
                'tanggal_selesai' => '2026-09-17',
                'waktu' => '09.00 - 15.00 WIB',
            ],
        ]);
    }
}
