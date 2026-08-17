<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'orang_tua') {
            abort(403, 'Akses hanya untuk orang tua.');
        }

        $orangTua = $user->orangTua()
            ->with('siswa.kelas')
            ->first();

        if (!$orangTua) {
            abort(403, 'Akun orang tua belum terhubung dengan data orang tua.');
        }

        return view('admin.orangtua.dashboard', compact('orangTua'));
    }
}  