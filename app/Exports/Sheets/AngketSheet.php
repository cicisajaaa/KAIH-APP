<?php

namespace App\Exports\Sheets;

use App\Models\AngketHarian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AngketSheet implements FromCollection, WithHeadings
{

    public function collection()
    {
        return AngketHarian::with('siswa')
            ->orderBy('tanggal','desc')
            ->get()
            ->map(function ($angket) {

                return [

                    $angket->tanggal,

                    $angket->siswa->nama_siswa ?? '-',

                    $angket->bangun_pagi ?? '-',

                    $angket->sholat_subuh ? 'Ya' : 'Tidak',

                    $angket->belajar ? 'Ya' : 'Tidak',

                    $angket->tidur_malam ?? '-',

                ];

            });
    }



    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Bangun Pagi',
            'Sholat Subuh',
            'Belajar',
            'Tidur Malam',
        ];
    }

}