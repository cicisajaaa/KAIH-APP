<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Models\AngketHarian;
use App\Models\OrangTua;

use Illuminate\Http\Request;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
class LaporanController extends Controller
{

    public function index(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | Filter tanggal angket
        |--------------------------------------------------------------------------
        */

        $tanggalMulai = $request->tanggal_mulai;

        $tanggalAkhir = $request->tanggal_akhir;



        /*
        |--------------------------------------------------------------------------
        | Data siswa
        |--------------------------------------------------------------------------
        */

        $siswas = Siswa::with([
            'kelas.jurusan',
            'orangTua'
        ])
        ->orderBy('nama_siswa')
        ->get();



        /*
        |--------------------------------------------------------------------------
        | Data angket
        |--------------------------------------------------------------------------
        */

        $angketQuery = AngketHarian::with([
            'siswa',
            'orangTua'
        ])
        ->orderBy('tanggal','desc');



        if ($tanggalMulai && $tanggalAkhir) {

            $angketQuery->whereBetween(
                'tanggal',
                [
                    $tanggalMulai,
                    $tanggalAkhir
                ]
            );

        }


        $angketHarian = $angketQuery->get();



        /*
        |--------------------------------------------------------------------------
        | Data orang tua
        |--------------------------------------------------------------------------
        */

        $orangTuas = OrangTua::with('siswa')
            ->orderBy('nama_orang_tua')
            ->get();


        return view(
            'admin.laporan.index',
            compact(
                'siswas',
                'angketHarian',
                'orangTuas',
                'tanggalMulai',
                'tanggalAkhir'
            )
        );

    }


    public function export()
    {
        return Excel::download(
            new LaporanExport,
            'laporan-siswa.xlsx'
        );
    }


}