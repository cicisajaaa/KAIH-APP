<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Siswa::with([
            'kelas.jurusan'
        ])
        ->get()
        ->map(function ($siswa) {

            return [
                'nis' => $siswa->nis,

                'nama_siswa' => $siswa->nama_siswa,

                'jenis_kelamin' => $siswa->jenis_kelamin,

                'kelas' => $siswa->kelas->nama_kelas ?? '-',

                'jurusan' => $siswa->kelas->jurusan->nama_jurusan ?? '-',
            ];

        });
    }


    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Jenis Kelamin',
            'Kelas',
            'Jurusan',
        ];
    }
}