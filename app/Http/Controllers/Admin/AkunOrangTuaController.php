<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;

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






        $passwordDefault =
            'Kaih#'.$siswa->nis;







        $user = User::updateOrCreate(

            [

                'orang_tua_id'=>$orangTua->id

            ],


            [

                'name'=>$orangTua->nama_orang_tua,


                'email'=>$siswa->nis.'@kaih.com',


                'role'=>'orang_tua',


                'password'=>Hash::make($passwordDefault),


                'must_change_password'=>true


            ]

        );







        if($user->wasRecentlyCreated)
        {

            $dibuat++;

        }
        else
        {

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
    public function index(Request $request)
    {


        $query = User::where(
            'role',
            'orang_tua'
        )

        ->with([

            'orangTua.siswa.kelas.jurusan'

        ]);








        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */


        if($request->filled('search'))
        {


            $search = $request->search;



            $query->where(function($q) use ($search){


                $q->where(
                    'name',
                    'like',
                    "%{$search}%"
                )


                ->orWhere(
                    'email',
                    'like',
                    "%{$search}%"
                )


                ->orWhereHas(
                    'orangTua',
                    function($ortu) use ($search){


                        $ortu->where(
                            'nama_orang_tua',
                            'like',
                            "%{$search}%"
                        )


                        ->orWhereHas(
                            'siswa',
                            function($siswa) use ($search){


                                $siswa->where(
                                    'nama_siswa',
                                    'like',
                                    "%{$search}%"
                                )


                                ->orWhere(
                                    'nis',
                                    'like',
                                    "%{$search}%"
                                );


                            }
                        );


                    }
                );


            });


        }









        /*
        |--------------------------------------------------------------------------
        | Filter kelas
        |--------------------------------------------------------------------------
        */


        if($request->filled('kelas_id'))
        {


            $query->whereHas(

                'orangTua.siswa',

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
        | Pagination
        |--------------------------------------------------------------------------
        */


        $users = $query

            ->orderBy(
                'name'
            )

            ->paginate(20)

            ->withQueryString();









        /*
        |--------------------------------------------------------------------------
        | Data kelas
        |--------------------------------------------------------------------------
        */


        $kelas = Kelas::withCount('siswas')

            ->with('jurusan')

            ->orderBy(
                'nama_kelas'
            )

            ->get();








        return view(

            'admin.akun-orangtua.index',

            compact(

                'users',

                'kelas'

            )

        );


    }









    /**
     * Reset password satu akun
     */
    public function resetPassword($id)
    {


        $user = User::findOrFail($id);






        if($user->role !== 'orang_tua')
        {

            abort(403);

        }








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









    /**
     * Reset semua password akun orang tua
     */
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





        $jumlah = 0;







        foreach($users as $user)
        {


            $nis = optional($user->orangTua)

                ->siswa

                ->nis;







            if($nis)
            {


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



                $jumlah++;


            }


        }








        return back()->with(

            'success',

            "Berhasil reset {$jumlah} akun orang tua."

        );


    }


}