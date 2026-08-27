<?php

namespace App\Exports\Sheets;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class SiswaSheet implements FromCollection, WithHeadings
{

    public function collection()
    {
        return Siswa::with([
            'kelas.jurusan'
        ])
        ->orderBy('nama_siswa')
        ->get()
        ->map(function ($siswa) {

            return [

                $siswa->nis,

                $siswa->nama_siswa,

                $siswa->jenis_kelamin,

                $siswa->kelas->nama_kelas ?? '-',

                $siswa->kelas->jurusan->nama_jurusan ?? '-',

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