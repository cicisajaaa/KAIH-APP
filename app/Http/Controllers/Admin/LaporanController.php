<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Models\AngketHarian;
use App\Models\OrangTua;
use App\Models\Kelas;

use Illuminate\Http\Request;

use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;



class LaporanController extends Controller
{


    public function index(Request $request)
    {


        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */


        $tanggalMulai = $request->tanggal_mulai;

        $tanggalAkhir = $request->tanggal_selesai;

        $kelasId = $request->kelas_id;




        $tanggalMonitoring = $tanggalMulai 
            ?? Carbon::today()->format('Y-m-d');






        /*
        |--------------------------------------------------------------------------
        | Dropdown Kelas
        |--------------------------------------------------------------------------
        */


        $kelas = Kelas::orderBy(
            'nama_kelas'
        )
        ->get();







        /*
        |--------------------------------------------------------------------------
        | Data Siswa Monitoring
        |--------------------------------------------------------------------------
        */


        $siswaQuery = Siswa::with([

            'kelas.jurusan',

            'orangTua'

        ]);





        if($kelasId)
        {

            $siswaQuery->where(
                'kelas_id',
                $kelasId
            );

        }





        $siswas = $siswaQuery

            ->orderBy(
                'nama_siswa'
            )

            ->get();









        /*
        |--------------------------------------------------------------------------
        | Tempel Status Angket Siswa
        |--------------------------------------------------------------------------
        */


        foreach($siswas as $siswa)
        {


            // Isi sesuai tanggal monitoring

            $siswa->angketHariIni = AngketHarian::where(
                    'siswa_id',
                    $siswa->id
                )
                ->whereDate(
                    'tanggal',
                    $tanggalMonitoring
                )
                ->first();





            // Cek telat 1 hari

            $siswa->angketTelat = AngketHarian::where(
                    'siswa_id',
                    $siswa->id
                )
                ->whereDate(
                    'tanggal',
                    Carbon::parse($tanggalMonitoring)
                        ->subDay()
                )
                ->whereDate(
                    'tanggal_pengisian',
                    Carbon::parse($tanggalMonitoring)
                )
                ->first();



        }










        /*
        |--------------------------------------------------------------------------
        | Data Detail Angket
        |--------------------------------------------------------------------------
        */


        $angketQuery = AngketHarian::with([

            'siswa.kelas',

            'orangTua'

        ]);





        if(
            $tanggalMulai &&
            $tanggalAkhir
        )
        {

            $angketQuery->whereBetween(

                'tanggal',

                [
                    $tanggalMulai,
                    $tanggalAkhir
                ]

            );

        }






        if($kelasId)
        {

            $angketQuery->whereHas(

                'siswa',

                function($q) use($kelasId){

                    $q->where(
                        'kelas_id',
                        $kelasId
                    );

                }

            );

        }





        $angketHarian = $angketQuery

            ->orderBy(
                'tanggal',
                'desc'
            )

            ->get();









        /*
        |--------------------------------------------------------------------------
        | Statistik Monitoring
        |--------------------------------------------------------------------------
        */


        $totalSiswa = $siswas->count();




        $sudahIsi = $siswas
            ->filter(function($siswa){

                return 
                    $siswa->angketHariIni ||
                    $siswa->angketTelat;

            })
            ->count();






        $belumIsi = 
            $totalSiswa - $sudahIsi;






        $persentasePengisian = 0;



        if($totalSiswa > 0)
        {

            $persentasePengisian = round(

                ($sudahIsi / $totalSiswa) * 100,

                1

            );

        }









        /*
        |--------------------------------------------------------------------------
        | Statistik Master
        |--------------------------------------------------------------------------
        */


        $totalOrangTua = OrangTua::count();


        $totalAngket = AngketHarian::count();





        $siswaLaki = Siswa::where(
            'jenis_kelamin',
            'L'
        )
        ->count();




        $siswaPerempuan = Siswa::where(
            'jenis_kelamin',
            'P'
        )
        ->count();








        /*
        |--------------------------------------------------------------------------
        | Statistik Kelas
        |--------------------------------------------------------------------------
        */


        $kelasStatistik = Kelas::withCount(

            'siswa'

        )
        ->with(
            'jurusan'
        )
        ->get();








        return view(

            'admin.laporan.index',

            compact(

                'siswas',

                'angketHarian',

                'kelas',

                'tanggalMulai',

                'tanggalAkhir',

                'kelasId',

                'tanggalMonitoring',


                'totalSiswa',

                'sudahIsi',

                'belumIsi',

                'persentasePengisian',


                'totalOrangTua',

                'totalAngket',

                'siswaLaki',

                'siswaPerempuan',

                'kelasStatistik'

            )

        );


    }








    public function export()
    {


        return Excel::download(

            new LaporanExport,

            'laporan-angket.xlsx'

        );


    }


}