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
        | TANGGAL HARI INI
        |--------------------------------------------------------------------------
        */


        $hariIni = Carbon::today();









        /*
        |--------------------------------------------------------------------------
        | STATISTIK ANGKET HARI INI
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








        if($totalSiswa > 0)
        {


            $persentaseAngket = round(

                ($angketHariIni / $totalSiswa) * 100,

                1

            );


        }
        else
        {


            $persentaseAngket = 0;


        }





/*
|--------------------------------------------------------------------------
| KONDISI SISWA TERAKHIR
|--------------------------------------------------------------------------
*/
$tanggalTerakhir = AngketHarian::max('tanggal') ?? Carbon::today();



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
        | SISWA PERLU PERHATIAN
        |--------------------------------------------------------------------------
        */
$siswaPerhatian = AngketHarian::with([

    'siswa.kelas'

])
->whereIn(

    'kategori',

    [
        'Perlu Perhatian',
        'Perlu Pendampingan'
    ]

)
->whereDate(
    'tanggal',
    $tanggalTerakhir
)
->limit(10)
->get();






        /*
        |--------------------------------------------------------------------------
        | GRAFIK 7 HARI TERAKHIR
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
        | SISWA BELUM ISI HARI INI
        |--------------------------------------------------------------------------
        */


        $siswaBelumIsi = Siswa::whereDoesntHave(

                'angketHarian',

                function($query) use($hariIni){


                    $query->whereDate(

                        'tanggal',

                        $hariIni

                    );


                }

            )

            ->with([

                'kelas'

            ])

            ->orderBy(

                'nama_siswa'

            )

            ->limit(10)

            ->get();







        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */


        return view(

            'admin.dashboard',

            compact(

                /*
                DATA MASTER
                */

                'totalJurusan',

                'totalKelas',

                'totalSiswa',

                'totalOrangTua',




                /*
                ANGKET
                */

                'angketHariIni',

                'belumIsiAngket',

                'persentaseAngket',



                /*
                KONDISI SISWA
                */

                'jumlahBaik',

                'jumlahPerhatian',

                'jumlahPendampingan',

                'siswaPerhatian',




                /*
                GRAFIK
                */

                'grafikTanggal',

                'grafikJumlah',




                /*
                BELUM ISI
                */

                'siswaBelumIsi',

               


            )

        );


    }


}