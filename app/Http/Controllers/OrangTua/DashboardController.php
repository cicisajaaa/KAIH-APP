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


        if(
            !$user ||
            $user->role !== 'orang_tua'
        )
        {

            abort(403);

        }







        /*
        |--------------------------------------------------------------------------
        | Ambil Data Orang Tua
        |--------------------------------------------------------------------------
        */

$orangTua = $user->orangTua()
->with([
    'siswa.kelas.jurusan',
    'siswa.angketHarian'
])
->first();






        if(!$orangTua || !$orangTua->siswa)
        {

            abort(
                403,
                'Akun belum terhubung dengan siswa.'
            );

        }






        $siswa = $orangTua->siswa;









        /*
        |--------------------------------------------------------------------------
        | Angket Hari Ini
        |--------------------------------------------------------------------------
        */


        $angketHariIni = AngketHarian::where(

                'siswa_id',

                $siswa->id

            )

            ->whereDate(

                'tanggal',

                Carbon::today()

            )

            ->first();









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
        | Riwayat Angket
        |--------------------------------------------------------------------------
        */

$riwayatAngket = AngketHarian::where(

        'siswa_id',

        $siswa->id

    )

    ->orderBy(

        'tanggal',

        'desc'

    )

    ->orderBy(

        'id',

        'desc'

    )

    ->get();







        /*
        |--------------------------------------------------------------------------
        | Statistik Perkembangan
        |--------------------------------------------------------------------------
        */


        $totalHari = $riwayatAngket->count();



$totalBelajar = $riwayatAngket
    ->where(
        'belajar',
        1
    )
    ->count();






        $persentaseBelajar = $totalHari > 0

            ?

            round(
                ($totalBelajar/$totalHari)*100
            )

            :

            0;








        $totalIbadah = 0;



        foreach($riwayatAngket as $item)
        {


            $totalIbadah +=


                $item->sholat_subuh +

                $item->sholat_dzuhur +

                $item->sholat_ashar +

                $item->sholat_magrib +

                $item->sholat_isya;


        }






        $persentaseIbadah = $totalHari > 0

            ?

            round(

                ($totalIbadah / ($totalHari*5))*100

            )

            :

            0;









        /*
        |--------------------------------------------------------------------------
        | Kondisi Terakhir
        |--------------------------------------------------------------------------
        */


        $angketTerakhir = $riwayatAngket->first();





        $skorTerakhir =

            $angketTerakhir->skor ?? 0;





        $kategoriTerakhir =

            $angketTerakhir->kategori ?? '-';

$statusKondisi = $kategoriTerakhir;

$rincianSkor = [

    'Subuh' => 
        $angketTerakhir && $angketTerakhir->sholat_subuh 
        ? 10 : 0,


    'Dzuhur' => 
        $angketTerakhir && $angketTerakhir->sholat_dzuhur 
        ? 10 : 0,


    'Ashar' => 
        $angketTerakhir && $angketTerakhir->sholat_ashar 
        ? 10 : 0,


    'Magrib' => 
        $angketTerakhir && $angketTerakhir->sholat_magrib 
        ? 10 : 0,


    'Isya' => 
        $angketTerakhir && $angketTerakhir->sholat_isya 
        ? 10 : 0,


    'Belajar' => 
        $angketTerakhir && $angketTerakhir->belajar 
        ? 20 : 0,


'Bangun Pagi' => 
    $angketTerakhir && $angketTerakhir->bangun_pagi
    ? (
        \Carbon\Carbon::parse($angketTerakhir->bangun_pagi)->hour >= 4 &&
        \Carbon\Carbon::parse($angketTerakhir->bangun_pagi)->hour <= 5
        ? 15
        : 10
    )
    : 0,


'Tidur Malam' => 
    $angketTerakhir && $angketTerakhir->tidur_malam
    ? (
        \Carbon\Carbon::parse($angketTerakhir->tidur_malam)->hour >= 20 &&
        \Carbon\Carbon::parse($angketTerakhir->tidur_malam)->hour <= 21
        ? 15
        : 10
    )
    : 0,

];





        /*
        |--------------------------------------------------------------------------
        | Riwayat Terbaru
        |--------------------------------------------------------------------------
        */


        $riwayatTerbaru = $riwayatAngket

            ->take(5);









        /*
        |--------------------------------------------------------------------------
        | Grafik 7 Hari
        |--------------------------------------------------------------------------
        */
 $grafikTanggal = [];

$grafikSkor = [];

$grafikIbadah = [];







        for($i = 6; $i >=0; $i--)
        {


            $tanggal = Carbon::today()

                ->subDays($i);






            $data = AngketHarian::where(

                    'siswa_id',

                    $siswa->id

                )

                ->whereDate(

                    'tanggal',

                    $tanggal

                )

                ->first();







            $grafikTanggal[] =

                $tanggal->format('d M');







$grafikSkor[] =

    $data

    ?

    $data->skor

    :

    0;






            if($data)
            {


                $ibadah =


                    $data->sholat_subuh +

                    $data->sholat_dzuhur +

                    $data->sholat_ashar +

                    $data->sholat_magrib +

                    $data->sholat_isya;





                $grafikIbadah[] =

                    ($ibadah/5)*100;



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

                'siswa',

                'angketHariIni',

                'statusKondisi',

                'jumlahIbadahHariIni',

                'statusBelajarHariIni',


                'persentaseBelajar',

                'persentaseIbadah',


                'skorTerakhir',

                'kategoriTerakhir',


                'rincianSkor',
                
                'riwayatTerbaru',

'grafikTanggal',

'grafikSkor',

'grafikIbadah'


            )

        );


    }


}