<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\AngketHarian;

use Illuminate\Http\Request;

use Carbon\Carbon;



class MonitoringAngketController extends Controller
{


    public function index(Request $request)
    {


        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */


        $tanggal = $request->tanggal
            ?? Carbon::today()->format('Y-m-d');



        $kelasId = $request->kelas_id;








        /*
        |--------------------------------------------------------------------------
        | Ambil kelas
        |--------------------------------------------------------------------------
        */


        $kelas = Kelas::orderBy(
            'nama_kelas'
        )
        ->get();









        /*
        |--------------------------------------------------------------------------
        | Data siswa
        |--------------------------------------------------------------------------
        */


        $query = Siswa::with([

            'kelas',

            'orangTua'

        ]);





        if($kelasId)
        {

            $query->where(
                'kelas_id',
                $kelasId
            );

        }





        $siswas = $query
            ->orderBy(
                'nama_siswa'
            )
            ->get();









        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */


        $totalSiswa = $siswas->count();





        $sudahIsi = AngketHarian::whereDate(

                'tanggal',

                $tanggal

            )

            ->when(
                $kelasId,

                function($q) use($kelasId){

                    $q->whereHas(
                        'siswa',
                        function($s) use($kelasId){

                            $s->where(
                                'kelas_id',
                                $kelasId
                            );

                        }
                    );

                }

            )

            ->distinct(
                'siswa_id'
            )

            ->count(
                'siswa_id'
            );







        $belumIsi =
            $totalSiswa - $sudahIsi;








        $persentase = $totalSiswa > 0

            ?

            round(
                ($sudahIsi / $totalSiswa) * 100
            )

            :

            0;







        return view(

            'admin.monitoring-angket.index',

            compact(

                'siswas',

                'kelas',

                'tanggal',

                'kelasId',

                'totalSiswa',

                'sudahIsi',

                'belumIsi',

                'persentase'

            )

        );



    }



    public function detail($siswa)
{

    $siswa = Siswa::with([

        'kelas',

        'orangTua',

        'angketHarian' => function($query){

            $query->orderBy(
                'tanggal',
                'desc'
            );

        }

    ])
    ->findOrFail($siswa);





    return view(

        'admin.monitoring-angket.detail',

        compact(
            'siswa'
        )

    );


}

}