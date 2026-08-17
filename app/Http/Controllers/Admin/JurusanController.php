<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
   public function index()
{
    $jurusans = Jurusan::orderBy('id', 'asc')->get();

    return view('admin.jurusan.index', compact('jurusans'));
}

    public function create()
{
    return view('admin.jurusan.create');
}



public function store(Request $request)
{
    $request->validate([
        'kode_jurusan' => 'required|unique:jurusans,kode_jurusan',
        'nama_jurusan' => 'required',
    ]);

    Jurusan::create([
        'kode_jurusan' => $request->kode_jurusan,
        'nama_jurusan' => $request->nama_jurusan,
    ]);

    return redirect()->route('jurusan.index')
                     ->with('success', 'Data jurusan berhasil ditambahkan.');
}

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
{
    $jurusan = Jurusan::findOrFail($id);

    return view('admin.jurusan.edit', compact('jurusan'));
}

    public function update(Request $request, string $id)
{
    $jurusan = Jurusan::findOrFail($id);

    $request->validate([
        'kode_jurusan' => 'required|unique:jurusans,kode_jurusan,' . $id,
        'nama_jurusan' => 'required',
    ]);

    $jurusan->update([
        'kode_jurusan' => $request->kode_jurusan,
        'nama_jurusan' => $request->nama_jurusan,
    ]);

    return redirect()->route('jurusan.index')
        ->with('success', 'Data jurusan berhasil diperbarui.');
}


   public function destroy(string $id)
{
    $jurusan = Jurusan::findOrFail($id);

    $jurusan->delete();

    return redirect()->route('jurusan.index')
        ->with('success', 'Data jurusan berhasil dihapus.');
}
}