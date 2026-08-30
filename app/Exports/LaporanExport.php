<?php

namespace App\Exports;


use App\Models\Siswa;

use Carbon\Carbon;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;


use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;



class LaporanExport implements

    FromCollection,

    WithHeadings,

    WithMapping,

    ShouldAutoSize,

    WithStyles

{


    protected $tanggalMulai;

    protected $tanggalAkhir;

    protected $kelasId;

    protected $kategori;

    protected $no = 0;

    public function __construct(

        $tanggalMulai = null,

        $tanggalAkhir = null,

        $kelasId = null,

        $kategori = null

    )

    {

        $this->tanggalMulai = $tanggalMulai;

        $this->tanggalAkhir = $tanggalAkhir;

        $this->kelasId = $kelasId;

        $this->kategori = $kategori;

    }







    public function collection()

    {


$query = Siswa::with([

    'kelas',

    'orangTua',

    'angketHarian' => function($q){

        if(
            $this->tanggalMulai &&
            $this->tanggalAkhir
        ){

            $q->whereBetween(
                'tanggal',
                [
                    $this->tanggalMulai,
                    $this->tanggalAkhir
                ]
            );

        }


        if($this->kategori)
        {

            $q->where(
                'kategori',
                $this->kategori
            );

        }


        $q->orderBy(
            'tanggal',
            'desc'
        )
        ->orderBy(
            'id',
            'desc'
        );

    }

]);




        if($this->kelasId)
        {

            $query->where(
                'kelas_id',
                $this->kelasId
            );

        }





        return $query

            ->orderBy(
                'nama_siswa'
            )

            ->get();



    }









    public function headings(): array

    {


        return [


            'No',

            'Nama Siswa',

            'NIS',

            'Kelas',

            'Orang Tua',

            'Jumlah Angket',

            'Rata-rata Skor',

            'Kategori Terakhir',

            'Terakhir Mengisi'


        ];


    }







public function map($siswa): array

{


    $this->no++;


    $angket = $siswa->angketHarian;










$terakhir = $angket

    ->sortByDesc(
        'tanggal'
    )
    ->sortByDesc(
        'id'
    )
    ->first();






        $orangTua = $siswa->orangTua->first();







     return [

    $this->no,


            $siswa->nama_siswa,


            $siswa->nis,


            $siswa->kelas->nama_kelas ?? '-',



            $orangTua->nama_orang_tua ?? '-',



            $angket->count(),



            round(

                $angket->avg('skor') ?? 0

            ),



            $terakhir->kategori ?? '-',



            $terakhir

                ?

                Carbon::parse(

                    $terakhir->tanggal

                )->format('d-m-Y')

                :

                '-'

        ];



    }









    public function styles(
        Worksheet $sheet
    )

    {


        return [


            1 => [

                'font'=>[

                    'bold'=>true

                ]

            ]


        ];


    }


}