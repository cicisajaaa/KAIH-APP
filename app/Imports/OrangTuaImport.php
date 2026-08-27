<?php

namespace App\Imports;


use App\Models\Siswa;
use App\Models\OrangTua;
//use App\Models\User;

use Illuminate\Support\Collection;
//use Illuminate\Support\Facades\Hash;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class OrangTuaImport implements ToCollection, WithHeadingRow
{


    public function collection(Collection $rows)
    {


        foreach($rows as $row)
        {


            $nis = trim(
                (string)($row['nis'] ?? '')
            );


            if(!$nis){
                continue;
            }



            $siswa = Siswa::where(
                'nis',
                $nis
            )->first();



            if(!$siswa){
                continue;
            }



            $this->buatOrangTua(

                $siswa,

                $row['nama_ayah'] ?? null,

                'Ayah',

                $row['pekerjaan_ayah'] ?? null,

                $row['no_hp_ayah'] ?? null

            );



            $this->buatOrangTua(

                $siswa,

                $row['nama_ibu'] ?? null,

                'Ibu',

                $row['pekerjaan_ibu'] ?? null,

                $row['no_hp_ibu'] ?? null

            );

        }

    }




    private function buatOrangTua(
        $siswa,
        $nama,
        $hubungan,
        $pekerjaan,
        $hp
    ){

        if(!$nama){
            return;
        }



        // $orangTua = OrangTua::updateOrCreate(

        //     [

        //         'siswa_id'=>$siswa->id,
        //         'hubungan'=>$hubungan

        //     ],

        //     [

        //         'nama_orang_tua'=>trim($nama),

        //         'pekerjaan'=>$pekerjaan,

        //         'no_hp'=>$hp

        //     ]

        // );




        User::updateOrCreate(

            [
                'orang_tua_id'=>$orangTua->id
            ],

            [

                'name'=>$orangTua->nama_orang_tua,


                'email'=>
                    Str::slug($orangTua->nama_orang_tua)
                    .$orangTua->id
                    .'@kaih.app',


                'password'=>
                    Hash::make('orangtua123'),


                'role'=>'orang_tua'

            ]

        );

    }

}