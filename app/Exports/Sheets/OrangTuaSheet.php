<?php

namespace App\Exports\Sheets;

use App\Models\OrangTua;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class OrangTuaSheet implements FromCollection, WithHeadings
{

    public function collection()
    {
        return OrangTua::with('siswa')
            ->orderBy('nama_orang_tua')
            ->get()
            ->map(function ($ortu) {

                return [

                    $ortu->nama_orang_tua,

                    $ortu->hubungan,

                    $ortu->siswa->nama_siswa ?? '-',

                    $ortu->no_hp ?? '-',

                    $ortu->pekerjaan ?? '-',

                ];

            });
    }



    public function headings(): array
    {
        return [
            'Nama Orang Tua',
            'Hubungan',
            'Nama Siswa',
            'No HP',
            'Pekerjaan',
        ];
    }

}