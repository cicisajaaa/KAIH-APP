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

    $siswas = Siswa::with('orangTua')
        ->get();


    $dibuat = 0;
    $diupdate = 0;
    $tidakAdaOrtu = 0;



    foreach($siswas as $siswa)
    {


        /*
        |--------------------------------------------------------------------------
        | Ambil wali utama
        |--------------------------------------------------------------------------
        */

        $orangTua = $siswa->orangTua
            ->where('hubungan','Ayah')
            ->first();



        if(!$orangTua)
        {

            $orangTua = $siswa->orangTua->first();

        }



        if(!$orangTua)
        {

            $tidakAdaOrtu++;

            continue;

        }






        /*
        |--------------------------------------------------------------------------
        | Password default
        |--------------------------------------------------------------------------
        */

        $passwordDefault = 'Kaih#'.$siswa->nis;






        /*
        |--------------------------------------------------------------------------
        | Cari akun
        |--------------------------------------------------------------------------
        */

        $user = User::where(
            'orang_tua_id',
            $orangTua->id
        )
        ->first();







        /*
        |--------------------------------------------------------------------------
        | Jika akun belum ada
        |--------------------------------------------------------------------------
        */

        if(!$user)
        {


            User::create([


                'name'
                =>
                $orangTua->nama_orang_tua,


                'email'
                =>
                $siswa->nis.'@kaih.com',


                'password'
                =>
                Hash::make($passwordDefault),


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







        /*
        |--------------------------------------------------------------------------
        | Jika akun sudah ada
        |--------------------------------------------------------------------------
        */
else
{


    $user->update([


        'name'
        =>
        $orangTua->nama_orang_tua,


        'email'
        =>
        $siswa->nis.'@kaih.com',


    ]);



    $diupdate++;


}
    }






    return back()->with(

        'success',

        "Generate selesai. Dibuat: {$dibuat}, diperbarui: {$diupdate}, tanpa orang tua: {$tidakAdaOrtu}"

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
        | Ambil NIS siswa
        |--------------------------------------------------------------------------
        */


        $nis = optional(
            $user->orangTua
        )
        ->siswa
        ->nis ?? null;







        if(!$nis)
        {

            return back()->with(

                'error',

                'Data siswa tidak ditemukan.'

            );

        }








        /*
        |--------------------------------------------------------------------------
        | Reset password
        |--------------------------------------------------------------------------
        */


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

            'Password berhasil direset. Password awal: Kaih#'.$nis

        );


    }

public function resetSemuaPassword()
{

    $users = User::where(
        'role',
        'orang_tua'
    )
    ->with(
        'orangTua.siswa'
    )
    ->get();


    $berhasil = 0;


    foreach($users as $user)
    {


        $nis = optional($user->orangTua)
            ->siswa
            ->nis ?? null;



        if(!$nis)
        {
            continue;
        }



        $user->update([


            'password'
            =>
            Hash::make(
                'Kaih#'.$nis
            ),


            'must_change_password'
            =>
            true,


        ]);



        $berhasil++;


    }




    return back()->with(

        'success',

        "Berhasil reset password {$berhasil} akun orang tua."

    );


}

}