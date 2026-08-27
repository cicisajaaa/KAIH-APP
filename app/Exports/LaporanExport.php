<?php

namespace App\Exports;


use App\Models\Siswa;
use App\Models\AngketHarian;

use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;



class LaporanExport implements
    FromCollection,
    WithHeadings,
    WithMapping
{


    protected $tanggal;





    public function __construct()
    {

        $this->tanggal = Carbon::today()
            ->format('Y-m-d');

    }







    public function collection()
    {


        $siswas = Siswa::with([

            'kelas',
            'orangTua'

        ])
        ->orderBy(
            'nama_siswa'
        )
        ->get();





        foreach($siswas as $siswa)
        {


            $siswa->angketHariIni = AngketHarian::where(

                    'siswa_id',

                    $siswa->id

                )
                ->whereDate(

                    'tanggal',

                    $this->tanggal

                )
                ->first();


        }





        return $siswas;


    }










    public function headings(): array
    {


        return [

            'No',

            'Nama Siswa',

            'NIS',

            'Kelas',

            'Orang Tua',

            'Tanggal Angket',

            'Tanggal Pengisian',

            'Status Pengisian',

            'Bangun Pagi',

            'Sholat Subuh',

            'Sholat Dzuhur',

            'Sholat Ashar',

            'Sholat Magrib',

            'Sholat Isya',

            'Jumlah Sholat',

            'Belajar',

            'Kegiatan Membantu',

            'Tidur Malam'

        ];


    }









    public function map($siswa): array
    {


        static $no = 0;


        $no++;





        /*
        |--------------------------------------------------------------------------
        | Belum Isi
        |--------------------------------------------------------------------------
        */


        if(!$siswa->angketHariIni)
        {

            return [

                $no,

                $siswa->nama_siswa,

                $siswa->nis,

                $siswa->kelas->nama_kelas ?? '-',

                $siswa->orangTua->nama_orang_tua ?? '-',

                '-',

                '-',

                'Belum Isi',

                '-',

                '-',

                '-',

                '-',

                '-',

                '-',

                '-',

                '-',

                '-',

                '-'

            ];

        }








        $item = $siswa->angketHariIni;






        $jumlahSholat =

            $item->sholat_subuh +

            $item->sholat_dzuhur +

            $item->sholat_ashar +

            $item->sholat_magrib +

            $item->sholat_isya;







        $statusPengisian =

            $item->tanggal == $item->tanggal_pengisian

            ?

            'Tepat Waktu'

            :

            'Terlambat';








        return [

            $no,


            $siswa->nama_siswa,


            $siswa->nis,


            $siswa->kelas->nama_kelas ?? '-',


            $siswa->orangTua->nama_orang_tua ?? '-',



            $item->tanggal,


            $item->tanggal_pengisian,


            $statusPengisian,



            $item->bangun_pagi ?? '-',



            $item->sholat_subuh ? 'Ya':'Tidak',


            $item->sholat_dzuhur ? 'Ya':'Tidak',


            $item->sholat_ashar ? 'Ya':'Tidak',


            $item->sholat_magrib ? 'Ya':'Tidak',


            $item->sholat_isya ? 'Ya':'Tidak',



            $jumlahSholat.'/5',



            $item->belajar ? 'Ya':'Tidak',



            $item->kegiatan_membantu ?? '-',



            $item->tidur_malam ?? '-'

        ];


    }


}