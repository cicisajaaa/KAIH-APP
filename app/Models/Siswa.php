<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Siswa extends Model
{

    use HasFactory;



    protected $fillable = [

        'nis',

        'nama_siswa',

        'jenis_kelamin',

        'kelas_id',

    ];







    /*
    |--------------------------------------------------------------------------
    | Relasi Kelas
    |--------------------------------------------------------------------------
    */

    public function kelas()
    {

        return $this->belongsTo(
            Kelas::class,
            'kelas_id'
        );

    }









    /*
    |--------------------------------------------------------------------------
    | Relasi Orang Tua
    |--------------------------------------------------------------------------
    |
    | 1 siswa dapat memiliki beberapa orang tua/wali
    |
    */


    public function orangTua()
    {

        return $this->hasMany(
            OrangTua::class,
            'siswa_id'
        );

    }









    /*
    |--------------------------------------------------------------------------
    | Relasi Angket Harian
    |--------------------------------------------------------------------------
    |
    | Riwayat aktivitas siswa
    |
    */


    public function angketHarian()
    {

        return $this->hasMany(
            AngketHarian::class,
            'siswa_id'
        );

    }


}