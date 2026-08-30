<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Siswa;
use App\Models\Kelas;

use App\Imports\SiswaImport;
use App\Exports\SiswaExport;

use Maatwebsite\Excel\Facades\Excel;



class SiswaController extends Controller
{


    /**
     * Menampilkan data siswa
     */
    public function index()
    {


        $siswas = Siswa::with([

            'kelas.jurusan',

            'orangTua.user'

        ])

        ->orderBy(
            'nama_siswa'
        )

        ->get();




        return view(

            'admin.siswa.index',

            compact(
                'siswas'
            )

        );


    }







    /**
     * Form tambah siswa
     */
    public function create()
    {


        $kelas = Kelas::with('jurusan')

            ->orderBy(
                'nama_kelas'
            )

            ->get();




        return view(

            'admin.siswa.create',

            compact(
                'kelas'
            )

        );


    }








    /**
     * Menyimpan siswa baru
     */
    public function store(Request $request)
    {


        $validated = $request->validate([


            'nis'
            =>
            'required|string|max:50|unique:siswas,nis',



            'nama_siswa'
            =>
            'required|string|max:255',



            'jenis_kelamin'
            =>
            'required|in:L,P',



            'kelas_id'
            =>
            'required|exists:kelas,id',



        ],[


            'nis.required'
            =>
            'NIS wajib diisi.',



            'nis.unique'
            =>
            'NIS tersebut sudah terdaftar.',



            'nama_siswa.required'
            =>
            'Nama siswa wajib diisi.',



            'jenis_kelamin.required'
            =>
            'Jenis kelamin wajib dipilih.',



            'jenis_kelamin.in'
            =>
            'Jenis kelamin harus L atau P.',



            'kelas_id.required'
            =>
            'Kelas wajib dipilih.',



            'kelas_id.exists'
            =>
            'Kelas tidak ditemukan.',


        ]);






        Siswa::create($validated);






        return redirect()

            ->route('siswa.index')

            ->with(

                'success',

                'Data siswa berhasil ditambahkan.'

            );


    }









    /**
     * Import Excel
     */
    public function import(Request $request)
    {


        $request->validate([


            'file'
            =>
            'required|mimes:xlsx,xls',



        ],[


            'file.required'
            =>
            'File Excel wajib dipilih.',



            'file.mimes'
            =>
            'File harus berformat XLS atau XLSX.',


        ]);







        Excel::import(

            new SiswaImport(
                $request->file('file')
            ),

            $request->file('file')

        );







        return redirect()

            ->route('siswa.index')

            ->with(

                'success',

                'Data siswa berhasil diimport.'

            );


    }









    /**
     * Export Excel
     */
    public function export()
    {


        return Excel::download(

            new SiswaExport,

            'data-siswa.xlsx'

        );


    }









    /**
     * Form edit siswa
     */
    public function edit($id)
    {


        $siswa = Siswa::findOrFail($id);




        $kelas = Kelas::with('jurusan')

            ->orderBy(
                'nama_kelas'
            )

            ->get();






        return view(

            'admin.siswa.edit',

            compact(

                'siswa',

                'kelas'

            )

        );


    }









    /**
     * Update siswa
     */
    public function update(Request $request,$id)
    {


        $siswa = Siswa::findOrFail($id);






        $validated = $request->validate([



            'nis'
            =>
            'required|string|max:50|unique:siswas,nis,'.$siswa->id,



            'nama_siswa'
            =>
            'required|string|max:255',



            'jenis_kelamin'
            =>
            'required|in:L,P',



            'kelas_id'
            =>
            'required|exists:kelas,id',



        ],[



            'nis.required'
            =>
            'NIS wajib diisi.',



            'nis.unique'
            =>
            'NIS sudah digunakan siswa lain.',



            'nama_siswa.required'
            =>
            'Nama siswa wajib diisi.',



            'jenis_kelamin.required'
            =>
            'Jenis kelamin wajib dipilih.',



            'kelas_id.required'
            =>
            'Kelas wajib dipilih.',



        ]);








        $siswa->update($validated);







        return redirect()

            ->route('siswa.index')

            ->with(

                'success',

                'Data siswa berhasil diperbarui.'

            );


    }









    /**
     * Hapus siswa
     */
    public function destroy($id)
    {


        $siswa = Siswa::findOrFail($id);



        $siswa->delete();






        return redirect()

            ->route('siswa.index')

            ->with(

                'success',

                'Data siswa berhasil dihapus.'

            );


    }



}