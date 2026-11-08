<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilSekolahsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Profil sekolah hanya satu baris, jadi dipakai updateOrInsert
        // supaya seeder aman dijalankan berulang kali.
        DB::table('profil_sekolahs')->updateOrInsert(
            ['npsn' => 10800462],
            [
                'nama_sekolah' => 'SMP Muhammadiyah 2 Kalianda',
                'alamat_sekolah' => 'JL. Raya Pematang, Way Urang, Kec. Kalianda, Kabupaten Lampung Selatan, Lampung 35511',
                'email_sekolah' => 'smp.muh2kld@yahoo.com',
                'telepon_sekolah' => '(0727) 321813',
                'logo_sekolah' => '', // dikosongkan dulu
                'call_center' => '081234567890',
            ]
        );
    }
}
