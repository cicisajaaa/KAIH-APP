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
        | Data Master
        |--------------------------------------------------------------------------
        */


        $totalJurusan = Jurusan::count();


        $totalKelas = Kelas::count();


        $totalSiswa = Siswa::count();


        $totalOrangTua = OrangTua::count();







        /*
        |--------------------------------------------------------------------------
        | Statistik Angket Hari Ini
        |--------------------------------------------------------------------------
        */


        $hariIni = Carbon::today();




        // jumlah siswa yang sudah isi


        $angketHariIni = AngketHarian::whereDate(
                'tanggal',
                $hariIni
            )
            ->count();







        // siswa yang belum isi


        $belumIsiAngket = Siswa::whereDoesntHave(
                'angketHarian',
                function($query) use ($hariIni){

                    $query->whereDate(
                        'tanggal',
                        $hariIni
                    );

                }
            )
            ->count();







        // persentase


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
        | Grafik Angket 7 Hari Terakhir
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
        | Daftar Siswa Belum Isi Hari Ini
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







        return view(

            'admin.dashboard',

            compact(

                'totalJurusan',

                'totalKelas',

                'totalSiswa',

                'totalOrangTua',


                'angketHariIni',

                'belumIsiAngket',

                'persentaseAngket',


                'grafikTanggal',

                'grafikJumlah',


                'siswaBelumIsi'

            )

        );


    }


}