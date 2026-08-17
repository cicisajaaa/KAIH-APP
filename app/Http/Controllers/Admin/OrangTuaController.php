<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Imports\OrangTuaImport;
use Maatwebsite\Excel\Facades\Excel;

class OrangTuaController extends Controller
{
    public function index()
    {
        $orangTuas = OrangTua::with('siswa')
            ->latest()
            ->get();

        return view('admin.orangtua.index', compact('orangTuas'));
    }

    public function create()
    {
        $siswas = Siswa::orderBy('nama_siswa')->get();

        return view('admin.orangtua.create', compact('siswas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_orang_tua' => 'required|string|max:255',
            'hubungan' => 'required|in:Ayah,Ibu,Wali',
            'no_hp' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        // Cegah data orang tua dengan hubungan yang sama untuk siswa yang sama
        $sudahAda = OrangTua::where('siswa_id', $request->siswa_id)
            ->where('hubungan', $request->hubungan)
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'siswa_id' => 'Data ' . $request->hubungan . ' untuk siswa tersebut sudah ada.'
                ]);
        }

        OrangTua::create([
            'siswa_id' => $request->siswa_id,
            'nama_orang_tua' => $request->nama_orang_tua,
            'hubungan' => $request->hubungan,
            'no_hp' => $request->no_hp,
            'pekerjaan' => $request->pekerjaan,
        ]);

        return redirect()
            ->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $siswas = Siswa::orderBy('nama_siswa')->get();

        return view(
            'admin.orangtua.edit',
            compact('orangTua', 'siswas')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'nama_orang_tua' => 'required|string|max:255',
            'hubungan' => 'required|in:Ayah,Ibu,Wali',
            'no_hp' => 'nullable|string|max:30',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        $orangTua = OrangTua::findOrFail($id);

        // Cek agar tidak bentrok dengan data lain
        $sudahAda = OrangTua::where('siswa_id', $request->siswa_id)
            ->where('hubungan', $request->hubungan)
            ->where('id', '!=', $orangTua->id)
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'siswa_id' => 'Data ' . $request->hubungan . ' untuk siswa tersebut sudah ada.'
                ]);
        }

        $orangTua->update([
            'siswa_id' => $request->siswa_id,
            'nama_orang_tua' => $request->nama_orang_tua,
            'hubungan' => $request->hubungan,
            'no_hp' => $request->no_hp,
            'pekerjaan' => $request->pekerjaan,
        ]);

        return redirect()
            ->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $orangTua = OrangTua::findOrFail($id);

        $orangTua->delete();

        return redirect()
            ->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(
            new OrangTuaImport,
            $request->file('file')
        );

        return redirect()
            ->route('orangtua.index')
            ->with('success', 'Data orang tua berhasil diimport.');
    }
}