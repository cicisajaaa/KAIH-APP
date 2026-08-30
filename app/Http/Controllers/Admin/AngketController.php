<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\AngketHarian;
use App\Models\Kelas;

use Illuminate\Http\Request;



class AngketController extends Controller
{


    public function index(Request $request)
    {


        $query = AngketHarian::with([

            'siswa.kelas',

            'orangTua'

        ]);




        if($request->tanggal)
        {

            $query->whereDate(

                'tanggal',

                $request->tanggal

            );

        }





        if($request->kelas_id)
        {


            $query->whereHas(

                'siswa',

                function($q) use ($request){


                    $q->where(

                        'kelas_id',

                        $request->kelas_id

                    );


                }

            );


        }






        $angket = $query

            ->orderBy(

                'tanggal',

                'desc'

            )

            ->get();







        $kelas = Kelas::orderBy(

            'nama_kelas'

        )

        ->get();







        return view(

            'admin.angket.index',

            compact(

                'angket',

                'kelas'

            )

        );


    }







    /*
    |--------------------------------------------------------------------------
    | Detail Angket
    |--------------------------------------------------------------------------
    */


    public function detail($id)
    {


        $angket = AngketHarian::with([

            'siswa.kelas',

            'orangTua'

        ])

        ->findOrFail($id);






        return view(

            'admin.angket.detail',

            compact(

                'angket'

            )

        );


    }



}