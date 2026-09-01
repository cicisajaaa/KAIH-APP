<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\AngketHarian;

use Carbon\Carbon;



class DashboardController extends Controller
{


    public function index()
    {


        /*
        |--------------------------------------------------------------------------
        | DATA MASTER
        |--------------------------------------------------------------------------
        */


        $totalJurusan = Jurusan::count();


        $totalKelas = Kelas::count();


        $totalSiswa = Siswa::count();


        $totalOrangTua = OrangTua::count();









        /*
        |--------------------------------------------------------------------------
        | TANGGAL
        |--------------------------------------------------------------------------
        */


        $hariIni = Carbon::today();







        /*
        |--------------------------------------------------------------------------
        | ANGKET HARI INI
        |--------------------------------------------------------------------------
        */


        $angketHariIni = AngketHarian::whereDate(
                'tanggal',
                $hariIni
            )
            ->count();








        $belumIsiAngket = Siswa::whereDoesntHave(

                'angketHarian',

                function($query) use($hariIni){

                    $query->whereDate(
                        'tanggal',
                        $hariIni
                    );

                }

            )

            ->count();








        $persentaseAngket = $totalSiswa > 0

            ?

            round(
                ($angketHariIni / $totalSiswa) * 100,
                1
            )

            :

            0;









        /*
        |--------------------------------------------------------------------------
        | KONDISI SISWA TERBARU
        |--------------------------------------------------------------------------
        */


        $tanggalTerakhir = AngketHarian::max(
            'tanggal'
        );



        if(!$tanggalTerakhir)
        {

            $tanggalTerakhir = $hariIni;

        }







        $jumlahBaik = AngketHarian::whereDate(

                'tanggal',

                $tanggalTerakhir

            )

            ->where(
                'kategori',
                'Baik'
            )

            ->count();







        $jumlahPerhatian = AngketHarian::whereDate(

                'tanggal',

                $tanggalTerakhir

            )

            ->where(
                'kategori',
                'Perlu Perhatian'
            )

            ->count();







        $jumlahPendampingan = AngketHarian::whereDate(

                'tanggal',

                $tanggalTerakhir

            )

            ->where(
                'kategori',
                'Perlu Pendampingan'
            )

            ->count();









        /*
        |--------------------------------------------------------------------------
        | SISWA PERLU MONITORING
        |--------------------------------------------------------------------------
        */


        $siswaPerhatian = AngketHarian::with([

                'siswa.kelas'

            ])

            ->whereDate(

                'tanggal',

                $tanggalTerakhir

            )

            ->whereIn(

                'kategori',

                [

                    'Perlu Perhatian',

                    'Perlu Pendampingan'

                ]

            )

            ->orderBy(
                'skor',
                'asc'
            )

            ->limit(10)

            ->get();









        /*
        |--------------------------------------------------------------------------
        | GRAFIK 7 HARI
        |--------------------------------------------------------------------------
        */


        $grafikTanggal = [];

        $grafikJumlah = [];






        for($i = 6; $i >= 0; $i--)
        {


            $tanggal = Carbon::today()
                ->subDays($i);




            $grafikTanggal[] =
                $tanggal->format('d M');





            $grafikJumlah[] =
                AngketHarian::whereDate(

                    'tanggal',

                    $tanggal

                )

                ->count();



        }









        /*
        |--------------------------------------------------------------------------
        | SISWA BELUM ISI ANGKET
        |--------------------------------------------------------------------------
        */


        $siswaBelumIsi = Siswa::with([

                'kelas'

            ])

            ->whereDoesntHave(

                'angketHarian',

                function($query) use($hariIni){


                    $query->whereDate(

                        'tanggal',

                        $hariIni

                    );


                }

            )

            ->orderBy(
                'nama_siswa'
            )

            ->limit(10)

            ->get();









        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */


        return view(

            'admin.dashboard',

            compact(

                // MASTER

                'totalJurusan',

                'totalKelas',

                'totalSiswa',

                'totalOrangTua',




                // ANGKET

                'angketHariIni',

                'belumIsiAngket',

                'persentaseAngket',




                // KONDISI

                'jumlahBaik',

                'jumlahPerhatian',

                'jumlahPendampingan',

                'siswaPerhatian',




                // GRAFIK

                'grafikTanggal',

                'grafikJumlah',




                // BELUM ISI

                'siswaBelumIsi'


            )

        );


    }


}