<?php

namespace App\Imports;

use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrangTuaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $nis = trim((string) ($row['nis'] ?? ''));

            if ($nis === '') {
                continue;
            }


            $siswa = Siswa::where('nis', $nis)->first();


            if (!$siswa) {
                continue;
            }



            /*
            |--------------------------------------------------------------------------
            | AYAH
            |--------------------------------------------------------------------------
            */

            if (!empty($row['nama_ayah'])) {

                $ayah = OrangTua::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'hubungan' => 'Ayah',
                    ],
                    [
                        'nama_orang_tua' => $row['nama_ayah'],
                        'pekerjaan' => $row['pekerjaan_ayah'] ?? null,
                        'no_hp' => null,
                    ]
                );


                User::updateOrCreate(
                    [
                        'orang_tua_id' => $ayah->id,
                    ],
                    [
                        'name' => $ayah->nama_orang_tua,
                        'email' => strtolower(str_replace(' ', '', $ayah->nama_orang_tua))
                            . $ayah->id
                            . '@kaih.app',

                        'password' => Hash::make('orangtua123'),

                        'role' => 'orang_tua',
                    ]
                );

            }




            /*
            |--------------------------------------------------------------------------
            | IBU
            |--------------------------------------------------------------------------
            */

            if (!empty($row['nama_ibu'])) {

                $ibu = OrangTua::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'hubungan' => 'Ibu',
                    ],
                    [
                        'nama_orang_tua' => $row['nama_ibu'],
                        'pekerjaan' => $row['pekerjaan_ibu'] ?? null,
                        'no_hp' => null,
                    ]
                );


                User::updateOrCreate(
                    [
                        'orang_tua_id' => $ibu->id,
                    ],
                    [
                        'name' => $ibu->nama_orang_tua,

                        'email' => strtolower(str_replace(' ', '', $ibu->nama_orang_tua))
                            . $ibu->id
                            . '@kaih.app',

                        'password' => Hash::make('orangtua123'),

                        'role' => 'orang_tua',
                    ]
                );

            }

        }
    }
}