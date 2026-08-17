<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Exports\KelasExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KelasImport; 

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $kelas = Kelas::with('jurusan')
                ->orderBy('nama_kelas')
                ->get();

    return view('admin.kelas.index', compact('kelas'));
}

    /**
     * Show the form for creating a new resource.
     */

public function create()
{
    $jurusans = Jurusan::orderBy('nama_jurusan')->get();

    return view('admin.kelas.create', compact('jurusans'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'nama_kelas' => 'required',
        'jurusan_id' => 'nullable'
    ]);

    Kelas::create([
        'nama_kelas' => $request->nama_kelas,
        'jurusan_id' => $request->jurusan_id
    ]);

    return redirect()
        ->route('kelas.index')
        ->with('success', 'Data kelas berhasil ditambahkan.');
}   

    public function export()
    {
        return Excel::download(
            new KelasExport(),
            'kelas.xlsx'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $kelas = Kelas::findOrFail($id);
    $jurusans = Jurusan::all();

    return view('admin.kelas.edit', compact('kelas', 'jurusans'));
}


    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
   $request->validate([
    'nama_kelas' => 'required',
    'jurusan_id' => 'nullable'
]);
    $kelas = Kelas::findOrFail($id);

    $kelas->update([
        'nama_kelas' => $request->nama_kelas,
        'jurusan_id' => $request->jurusan_id
    ]);

    return redirect()
        ->route('kelas.index')
        ->with('success', 'Data kelas berhasil diupdate');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy($id)
{
    $kelas = Kelas::findOrFail($id);

    $kelas->delete();

    return redirect()
        ->route('kelas.index')
        ->with('success', 'Data kelas berhasil dihapus');
}

public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(
        new KelasImport,
        $request->file('file')
    );

    return redirect()
        ->route('kelas.index')
        ->with('success', 'Data kelas berhasil diimport');
}
}
