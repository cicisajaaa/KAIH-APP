<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Kelas;
use App\Models\Jurusan;

use App\Exports\KelasExport;
use App\Imports\KelasImport;

use Maatwebsite\Excel\Facades\Excel;



class KelasController extends Controller
{


    /**
     * Menampilkan daftar kelas
     */
    public function index()
    {

        $kelas = Kelas::with('jurusan')
            ->orderBy('nama_kelas')
            ->get();



        return view(

            'admin.kelas.index',

            compact('kelas')

        );

    }








    /**
     * Form tambah kelas
     */
    public function create()
    {


        $jurusans = Jurusan::orderBy(
            'nama_jurusan'
        )
        ->get();



        return view(

            'admin.kelas.create',

            compact('jurusans')

        );


    }









    /**
     * Simpan kelas baru
     */
    public function store(Request $request)
    {


        $request->validate([


            'nama_kelas' => [
                'required',
                'string',
                'max:255'
            ],



            'jurusan_id' => [
                'nullable',
                'exists:jurusans,id'
            ]


        ]);







        Kelas::create([


            'nama_kelas'
            =>
            $request->nama_kelas,



            'jurusan_id'
            =>
            $request->jurusan_id ?: null


        ]);







        return redirect()

            ->route('kelas.index')

            ->with(

                'success',

                'Data kelas berhasil ditambahkan.'

            );


    }









    /**
     * Detail kelas
     */
    public function show($id)
    {


        $kelas = Kelas::with([

            'jurusan',

            'siswa'

        ])
        ->findOrFail($id);




        return view(

            'admin.kelas.show',

            compact('kelas')

        );


    }









    /**
     * Form edit kelas
     */
    public function edit($id)
    {


        $kelas = Kelas::findOrFail($id);



        $jurusans = Jurusan::orderBy(
            'nama_jurusan'
        )
        ->get();





        return view(

            'admin.kelas.edit',

            compact(

                'kelas',

                'jurusans'

            )

        );


    }









    /**
     * Update kelas
     */
    public function update(Request $request, $id)
    {


        $request->validate([


            'nama_kelas' => [
                'required',
                'string',
                'max:255'
            ],



            'jurusan_id' => [
                'nullable',
                'exists:jurusans,id'
            ]


        ]);







        $kelas = Kelas::findOrFail($id);





        $kelas->update([


            'nama_kelas'
            =>
            $request->nama_kelas,



            'jurusan_id'
            =>
            $request->jurusan_id ?: null


        ]);








        return redirect()

            ->route('kelas.index')

            ->with(

                'success',

                'Data kelas berhasil diperbarui.'

            );


    }









    /**
     * Hapus kelas
     */
    public function destroy($id)
    {


        $kelas = Kelas::findOrFail($id);



        $kelas->delete();





        return redirect()

            ->route('kelas.index')

            ->with(

                'success',

                'Data kelas berhasil dihapus.'

            );


    }









    /**
     * Export Excel
     */
    public function export()
    {


        return Excel::download(

            new KelasExport(),

            'kelas.xlsx'

        );


    }









    /**
     * Import Excel
     */
    public function import(Request $request)
    {


        $request->validate([


            'file' => [

                'required',

                'mimes:xlsx,xls'

            ]


        ]);







        Excel::import(

            new KelasImport,

            $request->file('file')

        );







        return redirect()

            ->route('kelas.index')

            ->with(

                'success',

                'Data kelas berhasil diimport.'

            );


    }


}