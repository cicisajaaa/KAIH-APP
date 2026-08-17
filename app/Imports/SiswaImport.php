<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        /*
        |--------------------------------------------------------------------------
        | Lewati baris kosong
        |--------------------------------------------------------------------------
        */

        if (
            empty($row['nama_lengkap']) &&
            empty($row['nis'])
        ) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil data dari Excel
        |--------------------------------------------------------------------------
        |
        | Format Excel:
        |
        | No | Nama Lengkap | JK | NISN | NIS
        |
        */

        $nama = trim($row['nama_lengkap'] ?? '');

        $jk = strtoupper(
            trim($row['jk'] ?? '')
        );

        $nis = trim(
            (string) ($row['nis'] ?? '')
        );


        /*
        |--------------------------------------------------------------------------
        | Validasi data wajib
        |--------------------------------------------------------------------------
        */

        if ($nama === '' || $nis === '') {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Normalisasi Jenis Kelamin
        |--------------------------------------------------------------------------
        |
        | Excel bisa berisi:
        |
        | L
        | P
        | LAKI-LAKI
        | PEREMPUAN
        | LAKI LAKI
        |
        | Kita ubah menjadi:
        |
        | L = Laki-laki
        | P = Perempuan
        |
        */

        if (
            in_array($jk, [
                'L',
                'LAKI-LAKI',
                'LAKI LAKI',
                'LAKI LAKI '
            ])
        ) {
            $jk = 'L';

        } elseif (
            in_array($jk, [
                'P',
                'PEREMPUAN',
                'WANITA'
            ])
        ) {
            $jk = 'P';

        } else {
            // Kalau jenis kelamin tidak dikenali,
            // jangan masukkan data tersebut.
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Cek NIS yang sudah ada
        |--------------------------------------------------------------------------
        |
        | Kalau NIS sudah ada di database,
        | data akan dilewati.
        |
        */

        $sudahAda = Siswa::where('nis', $nis)->exists();

        if ($sudahAda) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan siswa baru
        |--------------------------------------------------------------------------
        */

        return new Siswa([
            'nis' => $nis,
            'nama_siswa' => $nama,
            'jenis_kelamin' => $jk,
            'kelas_id' => null,
        ]);
    }
}