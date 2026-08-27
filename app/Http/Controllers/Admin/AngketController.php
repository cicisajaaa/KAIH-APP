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


        /*
        |--------------------------------------------------------------------------
        | Query Angket
        |--------------------------------------------------------------------------
        */


        $query = AngketHarian::with([

            'siswa.kelas',

            'orangTua'

        ]);






        /*
        |--------------------------------------------------------------------------
        | Filter Tanggal
        |--------------------------------------------------------------------------
        */


        if($request->tanggal)
        {

            $query->whereDate(

                'tanggal',

                $request->tanggal

            );

        }







        /*
        |--------------------------------------------------------------------------
        | Filter Kelas
        |--------------------------------------------------------------------------
        */


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








        /*
        |--------------------------------------------------------------------------
        | Ambil Data
        |--------------------------------------------------------------------------
        */


        $angket = $query

            ->orderBy(

                'tanggal',

                'desc'

            )

            ->get();









        /*
        |--------------------------------------------------------------------------
        | Data Kelas Untuk Filter
        |--------------------------------------------------------------------------
        */


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


}