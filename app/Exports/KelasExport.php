<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;

class KelasExport implements FromCollection
{
    public function collection()
    {
        return Kelas::with('jurusan')->get();
    }
}