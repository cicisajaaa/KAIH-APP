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

            'angketHarian'

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


        static $no = 0;


        $no++;





        $angket = $siswa->angketHarian;






        if(
            $this->tanggalMulai &&
            $this->tanggalAkhir
        )

        {

            $angket = $angket->whereBetween(

                'tanggal',

                [

                    $this->tanggalMulai,

                    $this->tanggalAkhir

                ]

            );

        }





        if($this->kategori)
        {

            $angket = $angket->where(

                'kategori',

                $this->kategori

            );

        }








        $terakhir = $angket

            ->sortByDesc(

                'tanggal'

            )

            ->first();







        $orangTua = $siswa->orangTua->first();







        return [


            $no,


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