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







    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */


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









    /*
    |--------------------------------------------------------------------------
    | Hitung Skor Aktivitas
    |--------------------------------------------------------------------------
    */


    public function hitungSkor()
    {


        $skor = 0;



        /*
        |--------------------------------------------------------------------------
        | Ibadah (40 poin)
        |--------------------------------------------------------------------------
        */


        $jumlahIbadah =

            $this->sholat_subuh +
            $this->sholat_dzuhur +
            $this->sholat_ashar +
            $this->sholat_magrib +
            $this->sholat_isya;



        $skor += ($jumlahIbadah / 5) * 40;







        /*
        |--------------------------------------------------------------------------
        | Belajar (30 poin)
        |--------------------------------------------------------------------------
        */


        if($this->belajar)
        {

            $skor += 30;

        }







        /*
        |--------------------------------------------------------------------------
        | Bangun Pagi (20 poin)
        |--------------------------------------------------------------------------
        */


        if($this->bangun_pagi)
        {


            $jamBangun = \Carbon\Carbon::parse(
                $this->bangun_pagi
            );


            if($jamBangun->hour <= 5)
            {

                $skor += 20;

            }

            elseif($jamBangun->hour <= 7)
            {

                $skor += 10;

            }


        }








        /*
        |--------------------------------------------------------------------------
        | Tidur Malam (10 poin)
        |--------------------------------------------------------------------------
        */


        if($this->tidur_malam)
        {


            $jamTidur = \Carbon\Carbon::parse(
                $this->tidur_malam
            );


            if($jamTidur->hour >= 21)
            {

                $skor += 10;

            }


        }







        return round($skor);


    }









    /*
    |--------------------------------------------------------------------------
    | Tentukan Kategori
    |--------------------------------------------------------------------------
    */


    public function tentukanKategori($skor)
    {


        if($skor >= 80)
        {

            return 'Baik';

        }


        elseif($skor >= 50)
        {

            return 'Perlu Perhatian';

        }


        else
        {

            return 'Perlu Pendampingan';

        }


    }



}