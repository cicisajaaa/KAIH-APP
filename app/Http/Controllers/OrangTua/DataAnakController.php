<?php

namespace App\Http\Controllers\OrangTua;


use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;



class DataAnakController extends Controller
{


    public function index()
    {


        $user = Auth::user();





        /*
        |--------------------------------------------------------------------------
        | Validasi Role
        |--------------------------------------------------------------------------
        */


        if(
            !$user ||
            $user->role !== 'orang_tua'
        )
        {

            abort(403);

        }







        /*
        |--------------------------------------------------------------------------
        | Ambil Data Orang Tua + Siswa
        |--------------------------------------------------------------------------
        */


     $orangTua = $user

    ->orangTua()

    ->with([

        'siswa.kelas.jurusan',

        'siswa.angketHarian' => function($query){

            $query->orderBy(
                'tanggal',
                'desc'
            );

        },

    ])

    ->first();







if(
    !$orangTua ||
    !$orangTua->siswa
)
{

    abort(
        403,
        'Akun orang tua belum terhubung dengan siswa.'
    );

}






        $siswa = $orangTua->siswa;









        /*
        |--------------------------------------------------------------------------
        | Statistik Angket
        |--------------------------------------------------------------------------
        */


        $angket = $siswa

            ->angketHarian;






        $totalAngket = $angket->count();







        /*
        |--------------------------------------------------------------------------
        | Statistik Belajar
        |--------------------------------------------------------------------------
        */


        $jumlahBelajar = $angket

            ->where(
                'belajar',
                true
            )

            ->count();







        $persentaseBelajar = $totalAngket > 0

            ?

            round(
                ($jumlahBelajar / $totalAngket) * 100
            )

            :

            0;









        /*
        |--------------------------------------------------------------------------
        | Statistik Ibadah
        |--------------------------------------------------------------------------
        */


        $jumlahIbadah = 0;



        foreach($angket as $item)
        {


            $jumlahIbadah +=


                $item->sholat_subuh +

                $item->sholat_dzuhur +

                $item->sholat_ashar +

                $item->sholat_magrib +

                $item->sholat_isya;


        }







        $persentaseIbadah = $totalAngket > 0

            ?

            round(

                ($jumlahIbadah /
                ($totalAngket * 5))
                * 100

            )

            :

            0;








        /*
        |--------------------------------------------------------------------------
        | Kirim Data View
        |--------------------------------------------------------------------------
        */


        return view(

            'orangtua.data-anak',

            compact(

                'orangTua',

                'siswa',

                'totalAngket',

                'persentaseBelajar',

                'persentaseIbadah'

            )

        );


    }


}