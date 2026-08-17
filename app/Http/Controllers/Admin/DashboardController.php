<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalJurusan = Jurusan::count();
        $totalKelas = Kelas::count();
        $totalSiswa = Siswa::count();

        $totalOrangTua = 0;

        return view('admin.dashboard', compact(
            'totalJurusan',
            'totalKelas',
            'totalSiswa',
            'totalOrangTua'
        ));
    }
}