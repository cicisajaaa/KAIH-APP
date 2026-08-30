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


    /*
    |--------------------------------------------------------------------------
    | Monitoring Utama
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {


        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */


        $tanggal = $request->tanggal
            ?? Carbon::today()->format('Y-m-d');


        $kelasId = $request->kelas_id;


        $kategori = $request->kategori;







        /*
        |--------------------------------------------------------------------------
        | DATA KELAS
        |--------------------------------------------------------------------------
        */


        $kelas = Kelas::orderBy(
            'nama_kelas'
        )
        ->get();







        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        */


        $query = Siswa::with([


            'kelas.jurusan',


            'orangTua',



            'angketHarian'=>function($q) use($tanggal){


                $q->whereDate(

                    'tanggal',

                    $tanggal

                )
                ->orderBy(
                    'id',
                    'desc'
                );


            }


        ]);








        if($kelasId)
        {

            $query->where(
                'kelas_id',
                $kelasId
            );

        }








        if($kategori)
        {


            $query->whereHas(

                'angketHarian',

                function($q) use(
                    $kategori,
                    $tanggal
                ){


                    $q->whereDate(

                        'tanggal',
                        $tanggal

                    )
                    ->where(
                        'kategori',
                        $kategori
                    );


                }

            );


        }








        $siswas = $query

            ->orderBy(
                'nama_siswa'
            )

            ->get();









        /*
        |--------------------------------------------------------------------------
        | TOTAL SISWA
        |--------------------------------------------------------------------------
        */


        $totalSiswa = $siswas->count();









        /*
        |--------------------------------------------------------------------------
        | JUMLAH SUDAH ISI
        |--------------------------------------------------------------------------
        */


        $angketQuery = AngketHarian::whereDate(

            'tanggal',

            $tanggal

        );







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








        if($kategori)
        {

            $angketQuery->where(
                'kategori',
                $kategori
            );

        }






        $sudahIsi = $angketQuery

            ->select('siswa_id')

            ->distinct()

            ->count();






        $belumIsi = 
            $totalSiswa - $sudahIsi;







        $persentase = $totalSiswa > 0

            ?

            round(
                ($sudahIsi / $totalSiswa) * 100
            )

            :

            0;









        /*
        |--------------------------------------------------------------------------
        | STATISTIK KATEGORI
        |--------------------------------------------------------------------------
        */


        $kategoriQuery = AngketHarian::whereDate(

            'tanggal',

            $tanggal

        );








        if($kelasId)
        {

            $kategoriQuery->whereHas(

                'siswa',

                function($q) use($kelasId){

                    $q->where(
                        'kelas_id',
                        $kelasId
                    );

                }

            );

        }







        $baik = (clone $kategoriQuery)

            ->where(
                'kategori',
                'Baik'
            )

            ->count();








        $perhatian = (clone $kategoriQuery)

            ->where(
                'kategori',
                'Perlu Perhatian'
            )

            ->count();








        $pendampingan = (clone $kategoriQuery)

            ->where(
                'kategori',
                'Perlu Pendampingan'
            )

            ->count();









        return view(

            'admin.monitoring-angket.index',

            compact(

                'siswas',

                'kelas',

                'tanggal',

                'kelasId',

                'kategori',

                'totalSiswa',

                'sudahIsi',

                'belumIsi',

                'persentase',

                'baik',

                'perhatian',

                'pendampingan'

            )

        );


    }









    /*
    |--------------------------------------------------------------------------
    | Detail Siswa
    |--------------------------------------------------------------------------
    */


    public function detail($siswa)
    {


        $siswa = Siswa::with([


            'kelas.jurusan',


            'orangTua',



            'angketHarian'=>function($query){


                $query

                ->orderBy(
                    'tanggal',
                    'desc'
                )

                ->orderBy(
                    'id',
                    'desc'
                );


            }



        ])

        ->findOrFail($siswa);







        $riwayat = $siswa->angketHarian;






        $totalAngket = $riwayat->count();






        $rataSkor = round(

            $riwayat->avg('skor') ?? 0

        );






        $angketTerakhir = $riwayat->first();






        $skorTerakhir =
            $angketTerakhir->skor ?? 0;






        $kategoriTerakhir =
            $angketTerakhir->kategori ?? '-';







        /*
        |--------------------------------------------------------------------------
        | Statistik Belajar
        |--------------------------------------------------------------------------
        */


        $totalBelajar = $riwayat

            ->where(
                'belajar',
                1
            )

            ->count();






        $persentaseBelajar = $totalAngket > 0

            ?

            round(
                ($totalBelajar/$totalAngket)*100
            )

            :

            0;









        /*
        |--------------------------------------------------------------------------
        | Statistik Ibadah
        |--------------------------------------------------------------------------
        */


        $totalIbadah = 0;



        foreach($riwayat as $item)
        {


            $totalIbadah +=

                $item->sholat_subuh +

                $item->sholat_dzuhur +

                $item->sholat_ashar +

                $item->sholat_magrib +

                $item->sholat_isya;


        }







        $persentaseIbadah = $totalAngket > 0

            ?

            round(

                ($totalIbadah /
                ($totalAngket * 5))

                * 100

            )

            :

            0;









        return view(

            'admin.monitoring-angket.detail',

            compact(

                'siswa',

                'totalAngket',

                'rataSkor',

                'skorTerakhir',

                'kategoriTerakhir',

                'persentaseBelajar',

                'persentaseIbadah'

            )

        );


    }


}