<?php

namespace App\Http\Controllers\OrangTua;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Models\AngketHarian;

use Carbon\Carbon;



class AngketController extends Controller
{


    /**
     * Riwayat angket
     */
    public function index()
    {


        $user = Auth::user();



        $orangTua = $user->orangTua()
            ->with([
                'siswa.kelas.jurusan',
                'angketHarian'
            ])
            ->first();



        if(!$orangTua)
        {

            abort(
                403,
                'Data orang tua belum terhubung.'
            );

        }





        $angketHarian = AngketHarian::where(
                'orang_tua_id',
                $orangTua->id
            )
            ->orderBy(
                'tanggal',
                'desc'
            )
            ->get();





        return view(

            'orangtua.angket.index',

            compact(

                'angketHarian',

                'orangTua'

            )

        );


    }









    /**
     * Form pengisian angket
     */
    public function create()
    {


        $user = Auth::user();



        $orangTua = $user->orangTua()
            ->with('siswa')
            ->first();




        if(!$orangTua || !$orangTua->siswa)
        {

            abort(
                403,
                'Data siswa belum terhubung.'
            );

        }





        $siswa = $orangTua->siswa;





        /*
        |--------------------------------------------------------------------------
        | Cek apakah hari ini sudah isi
        |--------------------------------------------------------------------------
        */


        $sudahIsiHariIni = AngketHarian::where(
                'siswa_id',
                $siswa->id
            )
            ->whereDate(
                'tanggal',
                Carbon::today()
            )
            ->exists();






        if($sudahIsiHariIni)
        {

            return redirect()

                ->route(
                    'orangtua.angket.index'
                )

                ->with(
                    'error',
                    'Angket hari ini sudah diisi.'
                );

        }





        $tanggalHariIni = Carbon::today()
            ->format('Y-m-d');






        return view(

            'orangtua.angket.create',

            compact(

                'orangTua',

                'siswa',

                'tanggalHariIni'

            )

        );


    }









    /**
     * Simpan angket
     */
    public function store(Request $request)
    {


        $user = Auth::user();





        $orangTua = $user->orangTua()
            ->with('siswa')
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






        /*
        |--------------------------------------------------------------------------
        | Validasi
        |--------------------------------------------------------------------------
        */


        $request->validate([


            'tanggal'
                =>
                'required|date',



            'bangun_pagi'
                =>
                'nullable',



            'sholat_subuh'
                =>
                'nullable|boolean',



            'sholat_dzuhur'
                =>
                'nullable|boolean',



            'sholat_ashar'
                =>
                'nullable|boolean',



            'sholat_magrib'
                =>
                'nullable|boolean',



            'sholat_isya'
                =>
                'nullable|boolean',



            'kegiatan_membantu'
                =>
                'nullable|string',



            'belajar'
                =>
                'nullable|boolean',



            'tidur_malam'
                =>
                'nullable',


        ]);









        /*
        |--------------------------------------------------------------------------
        | Validasi tanggal
        |--------------------------------------------------------------------------
        */


        $tanggalAktivitas = Carbon::parse(
            $request->tanggal
        );


        $hariIni = Carbon::today();






        if($tanggalAktivitas->gt($hariIni))
        {

            return back()

                ->with(
                    'error',
                    'Tanggal tidak boleh melebihi hari ini.'
                );

        }






        if(
            $tanggalAktivitas
            ->lt(
                $hariIni->copy()->subDay()
            )
        )
        {

            return back()

                ->with(
                    'error',
                    'Pengisian hanya bisa maksimal 1 hari sebelumnya.'
                );

        }









        /*
        |--------------------------------------------------------------------------
        | Cek duplikasi
        |--------------------------------------------------------------------------
        */


        $cek = AngketHarian::where(

                'siswa_id',

                $orangTua->siswa->id

            )

            ->whereDate(

                'tanggal',

                $request->tanggal

            )

            ->exists();







        if($cek)
        {

            return back()

                ->with(
                    'error',
                    'Angket pada tanggal tersebut sudah ada.'
                );

        }









        /*
        |--------------------------------------------------------------------------
        | Simpan database
        |--------------------------------------------------------------------------
        */


        try
        {


            DB::transaction(function() use(
                $request,
                $orangTua
            ){



                AngketHarian::create([



                    'orang_tua_id'
                    =>
                    $orangTua->id,



                    'siswa_id'
                    =>
                    $orangTua->siswa->id,



                    'tanggal'
                    =>
                    $request->tanggal,



                    'tanggal_pengisian'
                    =>
                    now(),




                    'bangun_pagi'
                    =>
                    $request->bangun_pagi,




                    'sholat_subuh'
                    =>
                    $request->boolean(
                        'sholat_subuh'
                    ),




                    'sholat_dzuhur'
                    =>
                    $request->boolean(
                        'sholat_dzuhur'
                    ),




                    'sholat_ashar'
                    =>
                    $request->boolean(
                        'sholat_ashar'
                    ),




                    'sholat_magrib'
                    =>
                    $request->boolean(
                        'sholat_magrib'
                    ),




                    'sholat_isya'
                    =>
                    $request->boolean(
                        'sholat_isya'
                    ),




                    'kegiatan_membantu'
                    =>
                    $request->kegiatan_membantu,




                    'belajar'
                    =>
                    $request->boolean(
                        'belajar'
                    ),




                    'tidur_malam'
                    =>
                    $request->tidur_malam,


                ]);



            });



        }
        catch(\Exception $e)
        {


            return back()

                ->with(
                    'error',
                    'Gagal menyimpan angket.'
                );


        }









        return redirect()

            ->route(
                'orangtua.dashboard'
            )

            ->with(
                'success',
                'Angket berhasil disimpan.'
            );


    }


}