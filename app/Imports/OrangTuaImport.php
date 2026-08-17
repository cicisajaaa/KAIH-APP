<?php

namespace App\Imports;

use App\Models\OrangTua;
use App\Models\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrangTuaImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // Ambil NIS dari Excel
            $nis = trim((string) ($row['nis'] ?? ''));

            // Lewati jika NIS kosong
            if ($nis === '') {
                continue;
            }

            // Cari siswa berdasarkan NIS
            $siswa = Siswa::where('nis', $nis)->first();

            // Jika siswa tidak ditemukan, lewati
            if (!$siswa) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | DATA AYAH
            |--------------------------------------------------------------------------
            */

            $namaAyah = trim((string) ($row['nama_ayah'] ?? ''));
            $pekerjaanAyah = trim((string) ($row['pekerjaan_ayah'] ?? ''));

            if ($namaAyah !== '') {

                OrangTua::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'hubungan' => 'Ayah',
                    ],
                    [
                        'nama_orang_tua' => $namaAyah,
                        'pekerjaan' => $pekerjaanAyah !== ''
                            ? $pekerjaanAyah
                            : null,
                        'no_hp' => null,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | DATA IBU
            |--------------------------------------------------------------------------
            */

            $namaIbu = trim((string) ($row['nama_ibu'] ?? ''));
            $pekerjaanIbu = trim((string) ($row['pekerjaan_ibu'] ?? ''));

            if ($namaIbu !== '') {

                OrangTua::updateOrCreate(
                    [
                        'siswa_id' => $siswa->id,
                        'hubungan' => 'Ibu',
                    ],
                    [
                        'nama_orang_tua' => $namaIbu,
                        'pekerjaan' => $pekerjaanIbu !== ''
                            ? $pekerjaanIbu
                            : null,
                        'no_hp' => null,
                    ]
                );
            }
        }
    }
}