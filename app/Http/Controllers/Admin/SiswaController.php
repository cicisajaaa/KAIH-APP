<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

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
    public function index(Request $request)
    {


        $query = Siswa::with([

            'kelas.jurusan',

            'orangTua.user'

        ]);





        /*
        |--------------------------------------------------------------------------
        | Search Nama / NIS
        |--------------------------------------------------------------------------
        */


        if($request->filled('search')){


            $search = $request->search;



            $query->where(function($q) use ($search){


                $q->where(
                    'nis',
                    'like',
                    '%'.$search.'%'
                )


                ->orWhere(
                    'nama_siswa',
                    'like',
                    '%'.$search.'%'
                );


            });


        }





        /*
        |--------------------------------------------------------------------------
        | Filter Kelas
        |--------------------------------------------------------------------------
        */


        if($request->filled('kelas_id')){


            $query->where(

                'kelas_id',

                $request->kelas_id

            );


        }





        $siswas = $query

            ->orderBy(
                'nama_siswa'
            )

            ->paginate(20)

            ->withQueryString();






  $kelas = Kelas::withCount('siswas')
    ->orderBy('nama_kelas')
    ->get();







        return view(

            'admin.siswa.index',

            compact(

                'siswas',

                'kelas'

            )

        );


    }






public function kelas($id)
{

    $kelas = Kelas::with('jurusan')
        ->findOrFail($id);



    $siswas = Siswa::with([
        'orangTua',
        'kelas'
    ])
    ->where(
        'kelas_id',
        $id
    )
    ->orderBy(
        'nama_siswa'
    )
    ->paginate(20);



    return view(
        'admin.siswa.kelas',
        compact(
            'kelas',
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
     * Simpan siswa baru
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
            'NIS sudah terdaftar.',


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
            'required|mimes:xlsx,xls|max:5120',



        ],[


            'file.required'
            =>
            'File Excel wajib dipilih.',


            'file.mimes'
            =>
            'File harus XLS atau XLSX.',


            'file.max'
            =>
            'Ukuran file maksimal 5MB.',


        ]);







        try {



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

        catch(\Exception $e){



            Log::error(

                $e->getMessage()

            );





            return redirect()

                ->route('siswa.index')

                ->with(

                    'error',

                    $e->getMessage()

                );


        }


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
     * Edit siswa
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



        ]);







        $siswa->update(

            $validated

        );







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