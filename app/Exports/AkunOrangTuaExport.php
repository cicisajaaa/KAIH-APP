<?php

namespace App\Exports;


use App\Models\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;



class AkunOrangTuaExport implements FromCollection, WithHeadings
{


    public function collection()
    {


        $users = User::where(
                'role',
                'orang_tua'
            )
            ->with([
                'orangTua.siswa.kelas'
            ])
            ->whereNotNull(
                'orang_tua_id'
            )
            ->get();




        return $users->map(function($user){



            return [

                'Nama Orang Tua'
                    =>
                    $user->name,



                'Nama Siswa'
                    =>
                    $user
                    ->orangTua
                    ->siswa
                    ->nama_siswa
                    ??
                    '-',



                'Kelas'
                    =>
                    $user
                    ->orangTua
                    ->siswa
                    ->kelas
                    ->nama_kelas
                    ??
                    '-',



                'Email Login'
                    =>
                    $user->email,



                'Password Awal'
                    =>
                    $user
                    ->orangTua
                    ->siswa
                    ->nis
                    ??
                    '-',

            ];


        });


    }







    public function headings(): array
    {

        return [

            'Nama Orang Tua',

            'Nama Siswa',

            'Kelas',

            'Email Login',

            'Password Awal'

        ];

    }



}