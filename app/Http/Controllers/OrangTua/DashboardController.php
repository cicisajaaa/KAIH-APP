<?php

namespace App\Http\Controllers\OrangTua;


use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Models\AngketHarian;

use App\Services\AngketService;

use Carbon\Carbon;




class DashboardController extends Controller
{


    public function index(AngketService $service)
    {


        $user = Auth::user();




        /*
        |--------------------------------------------------------------------------
        | Validasi User
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
        | Data Orang Tua
        |--------------------------------------------------------------------------
        */


$orangTua = $user->orangTua()

    ->with([

        'siswa.kelas.jurusan',

        'siswa.angketHarian' => function($query){

            $query
                ->orderBy('tanggal','desc')
                ->orderBy('id','desc');

        }

    ])

    ->first();







        if(
            !$orangTua ||
            !$orangTua->siswa
        )
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







        $statusAngketHariIni =
            $angketHariIni
            ?

            'Sudah Mengisi'

            :

            'Belum Mengisi';








        $jumlahIbadahHariIni = 0;


        $statusBelajarHariIni = false;







        if($angketHariIni)
        {


            $jumlahIbadahHariIni =


                ($angketHariIni->sholat_subuh ? 1 : 0) +

                ($angketHariIni->sholat_dzuhur ? 1 : 0) +

                ($angketHariIni->sholat_ashar ? 1 : 0) +

                ($angketHariIni->sholat_magrib ? 1 : 0) +

                ($angketHariIni->sholat_isya ? 1 : 0);





            $statusBelajarHariIni =
                $angketHariIni->belajar;


        }









        /*
        |--------------------------------------------------------------------------
        | Semua Riwayat Angket
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
        | Statistik Belajar
        |--------------------------------------------------------------------------
        */


        $totalHari =
            $riwayatAngket->count();






        $totalBelajar =
            $riwayatAngket

            ->where(
                'belajar',
                1
            )

            ->count();







        $persentaseBelajar =
            $totalHari > 0

            ?

            round(
                ($totalBelajar / $totalHari) * 100
            )

            :

            0;









        /*
        |--------------------------------------------------------------------------
        | Statistik Ibadah
        |--------------------------------------------------------------------------
        */


        $totalIbadah = 0;





        foreach($riwayatAngket as $item)
        {


            $totalIbadah +=


                ($item->sholat_subuh ? 1 : 0) +

                ($item->sholat_dzuhur ? 1 : 0) +

                ($item->sholat_ashar ? 1 : 0) +

                ($item->sholat_magrib ? 1 : 0) +

                ($item->sholat_isya ? 1 : 0);


        }








        $persentaseIbadah =

            $totalHari > 0

            ?

            round(
                ($totalIbadah / ($totalHari * 5)) * 100
            )

            :

            0;









        /*
        |--------------------------------------------------------------------------
        | Kondisi Terakhir
        |--------------------------------------------------------------------------
        */


        $angketTerakhir =
            $riwayatAngket->first();






        $skorTerakhir =
            $angketTerakhir?->skor ?? 0;






        $kategoriTerakhir =
            $angketTerakhir?->kategori ?? '-';






        $statusKondisi =
            $kategoriTerakhir;






        $alasanTidakSholat =
            $angketTerakhir?->alasan_tidak_sholat ?? null;









        /*
        |--------------------------------------------------------------------------
        | Detail Skor
        |--------------------------------------------------------------------------
        */


        $rincianSkor = $service->rincianSkor([



            'sholat_subuh' =>
                $angketTerakhir?->sholat_subuh ?? false,


            'sholat_dzuhur' =>
                $angketTerakhir?->sholat_dzuhur ?? false,


            'sholat_ashar' =>
                $angketTerakhir?->sholat_ashar ?? false,


            'sholat_magrib' =>
                $angketTerakhir?->sholat_magrib ?? false,


            'sholat_isya' =>
                $angketTerakhir?->sholat_isya ?? false,


            'belajar' =>
                $angketTerakhir?->belajar ?? false,


            'bangun_pagi' =>
                $angketTerakhir?->bangun_pagi,


            'tidur_malam' =>
                $angketTerakhir?->tidur_malam,


        ]);









        /*
        |--------------------------------------------------------------------------
        | Riwayat Terbaru
        |--------------------------------------------------------------------------
        */


        $riwayatTerbaru =
            $riwayatAngket->take(5);









        /*
        |--------------------------------------------------------------------------
        | Grafik 7 Hari
        |--------------------------------------------------------------------------
        */


        $grafikTanggal = [];

        $grafikSkor = [];

        $grafikIbadah = [];








        $dataGrafik = AngketHarian::where(
                'siswa_id',
                $siswa->id
            )

            ->whereBetween(
                'tanggal',
                [

                    Carbon::today()->subDays(6),

                    Carbon::today()

                ]
            )

            ->get()

            ->keyBy(function($item){

                return Carbon::parse(
                    $item->tanggal
                )
                ->format('Y-m-d');

            });








        for($i = 6; $i >= 0; $i--)
        {


            $tanggal =
                Carbon::today()
                ->subDays($i);






            $data =
                $dataGrafik->get(
                    $tanggal->format('Y-m-d')
                );







            $grafikTanggal[] =
                $tanggal->format('d M');








            $grafikSkor[] =
                $data?->skor ?? 0;








            if($data)
            {


                $ibadah =


                    ($data->sholat_subuh ? 1 : 0) +

                    ($data->sholat_dzuhur ? 1 : 0) +

                    ($data->sholat_ashar ? 1 : 0) +

                    ($data->sholat_magrib ? 1 : 0) +

                    ($data->sholat_isya ? 1 : 0);





                $grafikIbadah[] =
                    ($ibadah / 5) * 100;


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

                'statusAngketHariIni',


                'statusKondisi',


                'jumlahIbadahHariIni',


                'statusBelajarHariIni',


                'persentaseBelajar',

                'persentaseIbadah',


                'skorTerakhir',

                'kategoriTerakhir',

                'alasanTidakSholat',


                'rincianSkor',


                'riwayatTerbaru',


                'grafikTanggal',

                'grafikSkor',

                'grafikIbadah'


            )

        );


    }


}