<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Models\AngketHarian;

use Carbon\Carbon;


class DashboardController extends Controller
{


    public function index()
    {


        $user = Auth::user();



        /*
        |--------------------------------------------------------------------------
        | Validasi Role
        |--------------------------------------------------------------------------
        */

        if(!$user || $user->role !== 'orang_tua')
        {
            abort(403);
        }







        /*
        |--------------------------------------------------------------------------
        | Ambil Data Orang Tua + Anak
        |--------------------------------------------------------------------------
        */


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
                'Akun belum terhubung dengan siswa.'
            );
        }









        /*
        |--------------------------------------------------------------------------
        | Cek Angket Hari Ini
        |--------------------------------------------------------------------------
        */


        $angketHariIni = AngketHarian::where(
                'orang_tua_id',
                $orangTua->id
            )
            ->whereDate(
                'tanggal',
                Carbon::today()
            )
            ->first();








        /*
        |--------------------------------------------------------------------------
        | Ringkasan Hari Ini
        |--------------------------------------------------------------------------
        */


        $jumlahIbadahHariIni = 0;


        $statusBelajarHariIni = false;



        if($angketHariIni)
        {


            $jumlahIbadahHariIni =

                $angketHariIni->sholat_subuh +

                $angketHariIni->sholat_dzuhur +

                $angketHariIni->sholat_ashar +

                $angketHariIni->sholat_magrib +

                $angketHariIni->sholat_isya;




            $statusBelajarHariIni =

                $angketHariIni->belajar;


        }









        /*
        |--------------------------------------------------------------------------
        | Grafik Perkembangan 7 Hari
        |--------------------------------------------------------------------------
        */


        $grafikTanggal = [];

        $grafikBelajar = [];

        $grafikIbadah = [];





        for($i = 6; $i >= 0; $i--)
        {


            $tanggal = Carbon::today()
                ->subDays($i);




            $data = AngketHarian::where(
                    'siswa_id',
                    $orangTua->siswa->id
                )
                ->whereDate(
                    'tanggal',
                    $tanggal
                )
                ->first();







            /*
            |--------------------------------------------------------------------------
            | Label tanggal
            |--------------------------------------------------------------------------
            */


            $grafikTanggal[] =

                $tanggal->format('d M');








            /*
            |--------------------------------------------------------------------------
            | Grafik Belajar
            |--------------------------------------------------------------------------
            |
            | Ya = 100
            | Tidak = 0
            |
            */


            $grafikBelajar[] =

                $data

                ?

                ($data->belajar ? 100 : 0)

                :

                0;








            /*
            |--------------------------------------------------------------------------
            | Grafik Ibadah 5 Waktu
            |--------------------------------------------------------------------------
            */


            if($data)
            {


                $totalIbadah =


                    $data->sholat_subuh +

                    $data->sholat_dzuhur +

                    $data->sholat_ashar +

                    $data->sholat_magrib +

                    $data->sholat_isya;





                $grafikIbadah[] =

                    ($totalIbadah / 5) * 100;



            }
            else
            {


                $grafikIbadah[] = 0;


            }




        }









        return view(

            'orangtua.dashboard',

            compact(

                'orangTua',

                'angketHariIni',

                'jumlahIbadahHariIni',

                'statusBelajarHariIni',

                'grafikTanggal',

                'grafikBelajar',

                'grafikIbadah'

            )

        );


    }


}