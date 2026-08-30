<?php

namespace App\Http\Controllers\OrangTua;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;



class RiwayatAngketController extends Controller
{


    public function index(Request $request)
    {


        $user = Auth::user();




        if(
            !$user ||
            $user->role !== 'orang_tua'
        )
        {

            abort(403);

        }








        /*
        |--------------------------------------------------------------------------
        | Ambil Orang Tua + Anak
        |--------------------------------------------------------------------------
        */


        $orangTua = $user

            ->orangTua()

            ->with([
                'siswa'
            ])

            ->first();







        if(
            !$orangTua ||
            !$orangTua->siswa
        )
        {

            abort(
                403,
                'Data siswa belum tersedia.'
            );

        }







        $siswa = $orangTua->siswa;









        /*
        |--------------------------------------------------------------------------
        | Filter tanggal
        |--------------------------------------------------------------------------
        */


        $tanggalMulai = $request->tanggal_mulai;

        $tanggalAkhir = $request->tanggal_akhir;







        $query = $siswa

            ->angketHarian();








        if(
            $tanggalMulai &&
            $tanggalAkhir
        )
        {


            $query->whereBetween(

                'tanggal',

                [

                    $tanggalMulai,

                    $tanggalAkhir

                ]

            );


        }







        $riwayat = $query

            ->orderBy(

                'tanggal',

                'desc'

            )

            ->get();








        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */


        $total = $riwayat->count();





        $jumlahBelajar = $riwayat

            ->where(
                'belajar',
                true
            )

            ->count();







        $persentaseBelajar = $total > 0

            ?

            round(
                ($jumlahBelajar/$total)*100
            )

            :

            0;








        return view(

            'orangtua.riwayat.index',

            compact(

                'orangTua',

                'siswa',

                'riwayat',

                'tanggalMulai',

                'tanggalAkhir',

                'total',

                'persentaseBelajar'

            )

        );


    }


}