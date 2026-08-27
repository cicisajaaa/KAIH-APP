<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;


use App\Models\Siswa;
use App\Models\User;


use Illuminate\Support\Facades\Hash;




class AkunOrangTuaController extends Controller
{


    /**
     * Generate akun orang tua
     */
    public function generate()
    {


        /*
        |--------------------------------------------------------------------------
        | Ambil semua siswa beserta orang tua
        |--------------------------------------------------------------------------
        */

        $siswas = Siswa::with('orangTua')
            ->get();



        $dibuat = 0;

        $sudahAda = 0;







        foreach($siswas as $siswa)
        {



            /*
            |--------------------------------------------------------------------------
            | Ambil wali utama
            |--------------------------------------------------------------------------
            |
            | Prioritas:
            | 1. Ayah
            | 2. Orang tua pertama
            |
            */


            $orangTua = $siswa->orangTua
                ->where(
                    'hubungan',
                    'Ayah'
                )
                ->first();





            if(!$orangTua)
            {

                $orangTua = $siswa->orangTua
                    ->first();

            }







            /*
            |--------------------------------------------------------------------------
            | Tidak ada data orang tua
            |--------------------------------------------------------------------------
            */


            if(!$orangTua)
            {

                continue;

            }









            /*
            |--------------------------------------------------------------------------
            | Cek akun sudah ada atau belum
            |--------------------------------------------------------------------------
            */


            $user = User::where(

                'orang_tua_id',

                $orangTua->id

            )
            ->first();








            if($user)
            {

                $sudahAda++;

                continue;

            }









            /*
            |--------------------------------------------------------------------------
            | Akun baru
            |--------------------------------------------------------------------------
            |
            | Username awal:
            | 7000@kaih.com
            |
            | Password awal:
            | Kaih#7000
            |
            */


            User::create([



                'name'
                =>
                $orangTua->nama_orang_tua,




                'email'
                =>
                $siswa->nis.'@kaih.com',




                'password'
                =>
                Hash::make(
                    'Kaih#'.$siswa->nis
                ),




                'role'
                =>
                'orang_tua',




                'orang_tua_id'
                =>
                $orangTua->id,




                'must_change_password'
                =>
                true,


            ]);





            $dibuat++;




        }







        return back()->with(

            'success',

            "Generate selesai. Akun baru: {$dibuat}, akun sudah ada: {$sudahAda}"

        );


    }









    /**
     * Daftar akun orang tua
     */
    public function index()
    {


        $users = User::where(

                'role',

                'orang_tua'

            )

            ->with([

                'orangTua.siswa.kelas'

            ])

            ->orderBy(

                'name'

            )

            ->get();







        return view(

            'admin.akun-orangtua.index',

            compact(

                'users'

            )

        );


    }









    /**
     * Reset password akun orang tua
     */
    public function resetPassword($id)
    {


        $user = User::findOrFail($id);






        if(
            $user->role !== 'orang_tua'
        )
        {

            abort(403);

        }








        /*
        |--------------------------------------------------------------------------
        | Password kembali ke default
        |--------------------------------------------------------------------------
        */


        $nis = $user
            ->orangTua
            ->siswa
            ->nis;








        $user->update([



            'password'
            =>
            Hash::make(
                'Kaih#'.$nis
            ),




            'must_change_password'
            =>
            true



        ]);








        return back()->with(

            'success',

            'Password berhasil direset. Password awal kembali ke Kaih#'.$nis

        );


    }



}