<?php

namespace App\Imports;


use App\Models\Kelas;
use App\Models\Jurusan;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class KelasImport implements ToModel, WithHeadingRow
{


    public function model(array $row)
    {


        /*
        |--------------------------------------------------------------------------
        | Lewati baris kosong
        |--------------------------------------------------------------------------
        */

        if(empty($row['nama_kelas']))
        {

            return null;

        }








        /*
        |--------------------------------------------------------------------------
        | Cari jurusan jika tersedia
        |--------------------------------------------------------------------------
        */


        $jurusan = null;



        if(
            !empty($row['kode_jurusan'])
        )
        {


            $jurusan = Jurusan::where(

                'kode_jurusan',

                $row['kode_jurusan']

            )
            ->first();


        }








        /*
        |--------------------------------------------------------------------------
        | Cek kelas sudah ada
        |--------------------------------------------------------------------------
        */


        $kelas = Kelas::where(

            'nama_kelas',

            $row['nama_kelas']

        )
        ->first();







        if($kelas)
        {

            return null;

        }









        /*
        |--------------------------------------------------------------------------
        | Simpan kelas
        |--------------------------------------------------------------------------
        |
        | Jurusan boleh kosong
        |
        */


        return new Kelas([


            'nama_kelas'
            =>
            trim(
                $row['nama_kelas']
            ),



            'jurusan_id'
            =>
            $jurusan?->id



        ]);



    }


}