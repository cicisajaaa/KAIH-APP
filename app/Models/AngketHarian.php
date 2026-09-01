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

        'tanggal_pengisian',

        'bangun_pagi',

        'sholat_subuh',

        'sholat_dzuhur',

        'sholat_ashar',

        'sholat_magrib',

        'sholat_isya',

        'alasan_tidak_sholat',

        'kegiatan_membantu',

        'belajar',

        'tidur_malam',

        'skor',

        'kategori',

    ];



protected $casts = [

    'tanggal' => 'date',

    'tanggal_pengisian' => 'datetime',

    'sholat_subuh' => 'boolean',

    'sholat_dzuhur' => 'boolean',

    'sholat_ashar' => 'boolean',

    'sholat_magrib' => 'boolean',

    'sholat_isya' => 'boolean',

    'belajar' => 'boolean',

    'skor' => 'integer',

];







    public function orangTua()
    {

        return $this->belongsTo(
            OrangTua::class,
            'orang_tua_id'
        );

    }





    public function siswa()
    {

        return $this->belongsTo(
            Siswa::class,
            'siswa_id'
        );

    }


}