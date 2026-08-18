<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AngketHarian extends Model
{
    use HasFactory;

    protected $table = 'angket_harian';

    protected $fillable = [
        'orang_tua_id',
        'siswa_id',
        'tanggal',
        'bangun_pagi',
        'sholat_subuh',
        'sholat_ashar',
        'kegiatan_membantu',
        'sholat_magrib',
        'sholat_isya',
        'belajar',
        'tidur_malam',
    ];


    public function orangTua()
    {
        return $this->belongsTo(OrangTua::class);
    }


    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}