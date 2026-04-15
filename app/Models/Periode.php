<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun_pelajaran', 'tanggal_buka', 'tanggal_tutup', 'status', 'kuota_penerimaan',
    ];

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class);
    }

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public static function checkActivePeriod()
    {
        return self::where('status', 1)->exists();
    }
}
