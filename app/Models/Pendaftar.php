<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_pendaftaran',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'alamat',
        'alamat_ortu',
        'asal_sekolah',
        'nisn',
        'jenis_kelamin',
        'nama_ortu',
        'pekerjaan_ortu',
        'nomor_wa',
        'kartu_keluarga',
        'akte_kelahiran',
        'ijazah',
        'foto_calon_siswa',
        'ktp_orang_tua',
        'status_pendaftaran',
        'tanggal_tes',
        'catatan_penolakan',
        'nilai_tes_tertulis',
        'nilai_tes_praktek',
        'status_tes',
        'periode_id',
        'test_id',
        'nilai_akhir',
        'daftar_ulang',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function verify()
    {
        $this->status_pendaftaran = 'verified';
        $this->save();
    }

    public function reject($note)
    {
        $this->status_pendaftaran = 'rejected';
        $this->catatan_penolakan = $note;
        $this->save();
    }
}
