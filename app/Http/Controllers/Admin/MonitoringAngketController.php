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


    /**
     * Monitoring utama
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


            'kelas',


            'orangTua',



            'angketHarian'=>function($q) use($tanggal){


                $q->whereDate(

                    'tanggal',

                    $tanggal

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






        $belumIsi = $totalSiswa - $sudahIsi;







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









        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */


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









    /**
     * Detail siswa
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