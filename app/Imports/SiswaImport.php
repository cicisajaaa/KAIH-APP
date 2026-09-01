<?php

namespace App\Imports;


use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\OrangTua;


use Illuminate\Support\Collection;


use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


use PhpOffice\PhpSpreadsheet\IOFactory;



class SiswaImport implements WithMultipleSheets
{


    protected $file;



    public function __construct($file)
    {
        $this->file = $file;
    }







    public function sheets(): array
    {


        $spreadsheet = IOFactory::load(
            $this->file->getPathname()
        );



        $sheets = [];




        foreach(
            $spreadsheet->getSheetNames()
            as $sheetName
        )
        {



            $namaSheet = strtoupper(
                trim($sheetName)
            );




            /*
            |--------------------------------------------------------------------------
            | Abaikan sheet bukan data
            |--------------------------------------------------------------------------
            */


            if(
                in_array(
                    $namaSheet,
                    [

                        'DATA MBG',

                        'MUTASI',

                        'README',

                        'FORMAT',

                        'KETERANGAN'

                    ]
                )
            )
            {

                continue;

            }






            $sheets[$sheetName] =
                new SiswaSheetImport(
                    $sheetName
                );



        }




        return $sheets;



    }



}









class SiswaSheetImport implements ToCollection, WithHeadingRow
{


    protected $sheetName;





    public function __construct($sheetName)
    {
        $this->sheetName = $sheetName;
    }








    /*
    |--------------------------------------------------------------------------
    | Header Excel berada di baris 2
    |--------------------------------------------------------------------------
    */


    public function headingRow(): int
    {
        return 2;
    }









    public function collection(Collection $rows)
    {


        \Log::info(
            "IMPORT SHEET : ".$this->sheetName
        );







        /*
        |--------------------------------------------------------------------------
        | Ambil nama kelas dari nama sheet
        |--------------------------------------------------------------------------
        */


        $namaKelas = strtoupper(
            trim(
                preg_replace(
                    '/\s+/',
                    ' ',
                    str_replace(
                        'NEW',
                        '',
                        $this->sheetName
                    )
                )
            )
        );









        /*
        |--------------------------------------------------------------------------
        | Cari kelas fleksibel
        |--------------------------------------------------------------------------
        */


        $kelas = Kelas::whereRaw(

            'REPLACE(UPPER(nama_kelas)," ","") = ?',

            [

                str_replace(
                    ' ',
                    '',
                    $namaKelas
                )

            ]

        )
        ->first();








        if(!$kelas)
        {


            throw new \Exception(

                "Kelas {$namaKelas} belum tersedia di database."

            );


        }







        \Log::info(

            "KELAS DITEMUKAN : ".$kelas->nama_kelas

        );









        foreach($rows as $row)
        {






            /*
            |--------------------------------------------------------------------------
            | Ambil data siswa
            |--------------------------------------------------------------------------
            */


            $nis = trim(

                (string)
                (
                    $row['nis']
                    ??
                    ''
                )

            );





            $nama = trim(

                $row['nama_lengkap']
                ??
                $row['nama_siswa']
                ??
                $row['nama']
                ??
                ''

            );






            $jk = strtoupper(

                trim(

                    $row['jk']
                    ??
                    $row['jenis_kelamin']
                    ??
                    ''

                )

            );








            /*
            |--------------------------------------------------------------------------
            | Skip data kosong
            |--------------------------------------------------------------------------
            */


            if(
                empty($nis)
                ||
                empty($nama)
            )
            {

                continue;

            }









            /*
            |--------------------------------------------------------------------------
            | Normalisasi Jenis Kelamin
            |--------------------------------------------------------------------------
            */


            if(
                in_array(
                    $jk,
                    [

                        'L',

                        'LAKI-LAKI',

                        'LAKI LAKI'

                    ]
                )
            )
            {

                $jk = 'L';

            }


            elseif(
                in_array(
                    $jk,
                    [

                        'P',

                        'PEREMPUAN',

                        'WANITA'

                    ]
                )
            )
            {

                $jk = 'P';

            }


            else
            {

                continue;

            }









$siswa = Siswa::updateOrCreate(

    [

        'nis'=>$nis

    ],

    [

        'nama_siswa'=>$nama,

        'jenis_kelamin'=>$jk,

        'kelas_id'=>$kelas->id

    ]

);









            /*
            |--------------------------------------------------------------------------
            | Simpan Orang Tua Ayah
            |--------------------------------------------------------------------------
            */


            if(
                !empty($row['nama_ayah'])
            )
            {


                OrangTua::updateOrCreate(

                    [

                        'siswa_id'=>$siswa->id,

                        'hubungan'=>'Ayah'

                    ],


                    [

                        'nama_orang_tua'=>

                            trim(
                                $row['nama_ayah']
                            ),


                        'pekerjaan'=>

                            $row['pekerjaan_ayah']
                            ??
                            null,


                        'no_hp'=>

                            $row['no_hp_ayah']
                            ??
                            null


                    ]

                );


            }









            /*
            |--------------------------------------------------------------------------
            | Simpan Orang Tua Ibu
            |--------------------------------------------------------------------------
            */


            if(
                !empty($row['nama_ibu'])
            )
            {


                OrangTua::updateOrCreate(

                    [

                        'siswa_id'=>$siswa->id,

                        'hubungan'=>'Ibu'

                    ],


                    [

                        'nama_orang_tua'=>

                            trim(
                                $row['nama_ibu']
                            ),



                        'pekerjaan'=>

                            $row['pekerjaan_ibu']
                            ??
                            null,



                        'no_hp'=>

                            $row['no_hp_ibu']
                            ??
                            null


                    ]

                );


            }





        }







        \Log::info(

            "SELESAI IMPORT KELAS : ".$kelas->nama_kelas

        );



    }



}