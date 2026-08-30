<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Models\AngketHarian;
use App\Models\OrangTua;
use App\Models\Kelas;

use Illuminate\Http\Request;

use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;



class LaporanController extends Controller
{


    public function index(Request $request)
    {


        /*
        |--------------------------------------------------------------------------
        | Filter
        |--------------------------------------------------------------------------
        */


        $tanggalMulai = $request->tanggal_mulai;

        $tanggalAkhir = $request->tanggal_selesai;

        $kelasId = $request->kelas_id;

$kategori = $request->kategori;




        $tanggalMonitoring = $tanggalMulai 
            ?? Carbon::today()->format('Y-m-d');






        /*
        |--------------------------------------------------------------------------
        | Dropdown Kelas
        |--------------------------------------------------------------------------
        */


        $kelas = Kelas::orderBy(
            'nama_kelas'
        )
        ->get();







        /*
        |--------------------------------------------------------------------------
        | Data Siswa Monitoring
        |--------------------------------------------------------------------------
        */


$siswaQuery = Siswa::with([

    'kelas.jurusan',

    'orangTua',

    'angketHarian' => function($query) use(
        $tanggalMulai,
        $tanggalAkhir
    ){

        if(
            $tanggalMulai &&
            $tanggalAkhir
        ){

            $query->whereBetween(
                'tanggal',
                [
                    $tanggalMulai,
                    $tanggalAkhir
                ]
            );

        }


$query->orderBy(
    'tanggal',
    'desc'
)
->orderBy(
    'id',
    'desc'
);


    }

]);





        if($kelasId)
        {

            $siswaQuery->where(
                'kelas_id',
                $kelasId
            );

        }





        $siswas = $siswaQuery

            ->orderBy(
                'nama_siswa'
            )

            ->get();









        /*
        |--------------------------------------------------------------------------
        | Tempel Status Angket Siswa
        |--------------------------------------------------------------------------
        */

foreach($siswas as $siswa)
{


$siswa->angketHariIni = $siswa
    ->angketHarian
    ->where(
        'tanggal',
        $tanggalMonitoring
    )
    ->first();



$siswa->angketTelat = $siswa
    ->angketHarian
    ->where(
        'tanggal',
        Carbon::parse($tanggalMonitoring)
        ->subDay()
        ->format('Y-m-d')
    )
    ->first();



}









        /*
        |--------------------------------------------------------------------------
        | Data Detail Angket
        |--------------------------------------------------------------------------
        */


        $angketQuery = AngketHarian::with([

            'siswa.kelas',

            'orangTua'

        ]);





        if(
            $tanggalMulai &&
            $tanggalAkhir
        )
        {

            $angketQuery->whereBetween(

                'tanggal',

                [
                    $tanggalMulai,
                    $tanggalAkhir
                ]

            );

        }






        if($kelasId)
        {

            $angketQuery->whereHas(

                'siswa',

                function($q) use($kelasId){

                    $q->where(
                        'kelas_id',
                        $kelasId
                    );

                }

            );

        }




$angketHarian = $angketQuery

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
        | Statistik Monitoring
        |--------------------------------------------------------------------------
        */


        $totalSiswa = $siswas->count();




        $sudahIsi = $siswas
            ->filter(function($siswa){

                return 
                    $siswa->angketHariIni ||
                    $siswa->angketTelat;

            })
            ->count();






        $belumIsi = 
            $totalSiswa - $sudahIsi;






        $persentasePengisian = 0;



        if($totalSiswa > 0)
        {

            $persentasePengisian = round(

                ($sudahIsi / $totalSiswa) * 100,

                1

            );

        }






/*
|--------------------------------------------------------------------------
| Statistik Kondisi Siswa
|--------------------------------------------------------------------------
*/


$angketPeriode = AngketHarian::query();



if(
    $tanggalMulai &&
    $tanggalAkhir
)
{

    $angketPeriode
        ->whereBetween(
            'tanggal',
            [
                $tanggalMulai,
                $tanggalAkhir
            ]
        );

}






if($kelasId)
{

    $angketPeriode->whereHas(

        'siswa',

        function($q) use($kelasId){

            $q->where(
                'kelas_id',
                $kelasId
            );

        }

    );

}


if($kategori)
{

    $angketPeriode->where(
        'kategori',
        $kategori
    );

}

$angketPeriode = $angketPeriode->get();






$rataRataSkor = round(

    $angketPeriode
        ->avg('skor') ?? 0

);





$jumlahBaik = $angketPeriode

    ->where(
        'kategori',
        'Baik'
    )

    ->count();





$jumlahPerhatian = $angketPeriode

    ->where(
        'kategori',
        'Perlu Perhatian'
    )

    ->count();





$jumlahPendampingan = $angketPeriode

    ->where(
        'kategori',
        'Perlu Pendampingan'
    )

    ->count();


        /*
        |--------------------------------------------------------------------------
        | Statistik Master
        |--------------------------------------------------------------------------
        */


        $totalOrangTua = OrangTua::count();


        $totalAngket = $angketPeriode->count();

$persentaseBaik = 0;

if($totalAngket > 0)
{

    $persentaseBaik = round(
        ($jumlahBaik / $totalAngket) * 100
    );

}



        $siswaLaki = Siswa::where(
            'jenis_kelamin',
            'L'
        )
        ->count();




        $siswaPerempuan = Siswa::where(
            'jenis_kelamin',
            'P'
        )
        ->count();








        /*
        |--------------------------------------------------------------------------
        | Statistik Kelas
        |--------------------------------------------------------------------------
        */


        $kelasStatistik = Kelas::withCount(

            'siswa'

        )
        ->with(
            'jurusan'
        )
        ->get();








        return view(

            'admin.laporan.index',

            compact(

                'siswas',

                'angketHarian',

                'kelas',

                'tanggalMulai',

                'tanggalAkhir',

                'kelasId',

                'tanggalMonitoring',


                'totalSiswa',

                'sudahIsi',

                'belumIsi',

                'persentasePengisian',

                'persentaseBaik',

                'totalOrangTua',

                'totalAngket',

                'kategori',

                'siswaLaki',

                'siswaPerempuan',

                'kelasStatistik',

                'rataRataSkor',

'jumlahBaik',

'jumlahPerhatian',

'jumlahPendampingan'

            )

        );


    }







public function export(Request $request)
{


    return Excel::download(

        new LaporanExport(

            $request->tanggal_mulai,

            $request->tanggal_selesai,

            $request->kelas_id,

            $request->kategori

        ),

        'laporan-angket.xlsx'

    );


}


public function pdf(Request $request)
{

    $query = AngketHarian::with([

        'siswa.kelas',

        'orangTua'

    ]);



    if(
        $request->tanggal_mulai &&
        $request->tanggal_selesai
    )
    {

        $query->whereBetween(

            'tanggal',

            [

                $request->tanggal_mulai,

                $request->tanggal_selesai

            ]

        );

    }




    if($request->kelas_id)
    {

        $query->whereHas(

            'siswa',

            function($q) use($request){

                $q->where(
                    'kelas_id',
                    $request->kelas_id
                );

            }

        );

    }




    if($request->kategori)
    {

        $query->where(
            'kategori',
            $request->kategori
        );

    }




$angket = $query

    ->orderBy(
        'tanggal',
        'desc'
    )
    ->orderBy(
        'id',
        'desc'
    )
    ->get();






    $pdf = Pdf::loadView(

        'admin.laporan.pdf',

        [

            'angket'=>$angket,

'tanggalMulai'=>$request->tanggal_mulai,

'tanggalAkhir'=>$request->tanggal_selesai
        ]

    );





    return $pdf->download(
        'laporan-monitoring-angket.pdf'
    );

}
}