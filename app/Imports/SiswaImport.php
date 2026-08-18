<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        // Lewati baris kosong
        if (
            empty($row['nama_lengkap']) &&
            empty($row['nis'])
        ) {
            return null;
        }


        $nama = trim($row['nama_lengkap'] ?? '');

        $nis = trim(
            (string) ($row['nis'] ?? '')
        );


        $jk = strtoupper(
            trim($row['jk'] ?? '')
        );


        // Validasi wajib
        if ($nama === '' || $nis === '') {
            return null;
        }


        // Normalisasi jenis kelamin
        if (
            in_array($jk, [
                'L',
                'LAKI-LAKI',
                'LAKI LAKI'
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

            return null;

        }


        // Cari kelas
        $namaKelas = trim(
            $row['nama_kelas'] ?? ''
        );


        $kelas = Kelas::where(
            'nama_kelas',
            $namaKelas
        )->first();


        // Jika kelas tidak ditemukan
        if (!$kelas) {
            return null;
        }


        // Cegah duplikat NIS
        if (
            Siswa::where('nis', $nis)->exists()
        ) {
            return null;
        }


        return new Siswa([
            'nis' => $nis,
            'nama_siswa' => $nama,
            'jenis_kelamin' => $jk,
            'kelas_id' => $kelas->id,
        ]);
    }
}