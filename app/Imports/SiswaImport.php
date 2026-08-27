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
        ){

            $namaSheet = strtoupper(trim($sheetName));



            // Skip sheet bukan data siswa

            if(
                in_array(
                    $namaSheet,
                    [
                        'DATA MBG',
                        'MUTASI'
                    ]
                )
            ){

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
    | Header Excel
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


        \Log::info(
            "JUMLAH ROW : ".$rows->count()
        );




        /*
        |--------------------------------------------------------------------------
        | Buat kelas berdasarkan nama sheet
        |--------------------------------------------------------------------------
        */


        $kelas = Kelas::firstOrCreate(

            [

                'nama_kelas'=>trim(
                    str_replace(
                        'NEW',
                        '',
                        strtoupper($this->sheetName)
                    )
                )

            ]

        );







        foreach($rows as $row)
        {


            /*
            |--------------------------------------------------------------------------
            | Data siswa
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






            if(
                empty($nis)
                ||
                empty($nama)
            ){

                continue;

            }






            /*
            |--------------------------------------------------------------------------
            | Normalisasi JK
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
            ){

                $jk='L';

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

            ){

                $jk='P';

            }

            else{

                continue;

            }







            /*
            |--------------------------------------------------------------------------
            | Simpan siswa
            |--------------------------------------------------------------------------
            */


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
            | Ayah
            |--------------------------------------------------------------------------
            */


            if(
                !empty($row['nama_ayah'])
            ){

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
            | Ibu
            |--------------------------------------------------------------------------
            */


            if(
                !empty($row['nama_ibu'])
            ){

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
            "SELESAI SHEET : ".$this->sheetName
        );


    }


}