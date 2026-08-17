<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Siswa::with('kelas')
            ->get()
            ->map(function ($siswa) {

                return [
                    'nis' => $siswa->nis,
                    'nama_siswa' => $siswa->nama_siswa,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'kelas' => $siswa->kelas?->nama_kelas ?? '-',
                ];

            });
    }

    public function headings(): array
    {
        return [
            'nis',
            'nama_siswa',
            'jenis_kelamin',
            'kelas',
        ];
    }
}