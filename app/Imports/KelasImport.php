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
        // Lewati baris kosong
        if (empty($row['nama_kelas'])) {
            return null;
        }


        // Cari jurusan berdasarkan kode
        $jurusan = Jurusan::where(
            'kode_jurusan',
            $row['kode_jurusan'] ?? null
        )->first();


        // Jika jurusan tidak ditemukan
        // jangan masukkan kelas
        if (!$jurusan) {
            return null;
        }


        // Cek kelas sudah ada
        $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])
            ->where('jurusan_id', $jurusan->id)
            ->first();


        if ($kelas) {
            return null;
        }


        return new Kelas([
            'nama_kelas' => $row['nama_kelas'],
            'jurusan_id' => $jurusan->id,
        ]);
    }
}