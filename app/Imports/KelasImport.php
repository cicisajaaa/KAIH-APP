<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;

class KelasImport implements ToModel
{
    public function model(array $row)
    {
        return new Kelas([
            'nama_kelas' => $row[0],
            'jurusan_id' => $row[1],
        ]);
    }
}