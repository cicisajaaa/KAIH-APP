<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\Kelas;

use App\Imports\OrangTuaImport;

use Maatwebsite\Excel\Facades\Excel;



class OrangTuaController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | DATA ORANG TUA
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {


        $query = OrangTua::with([
            'siswa.kelas'
        ]);




        // SEARCH

        if($request->filled('search')){


            $search = $request->search;


            $query->where(function($q) use ($search){


$q->where(
    'nama_orang_tua',
    'like',
    "%{$search}%"
)

->orWhere(
    'no_hp',
    'like',
    "%{$search}%"
)

                ->orWhereHas(
                    'siswa',
                    function($s) use ($search){


                        $s->where(
                            'nama_siswa',
                            'like',
                            "%{$search}%"
                        )


                        ->orWhere(
                            'nis',
                            'like',
                            "%{$search}%"
                        );


                    }
                );


            });


        }






        // FILTER KELAS

        if($request->filled('kelas_id')){


            $query->whereHas(
                'siswa',
                function($q) use ($request){


                    $q->where(
                        'kelas_id',
                        $request->kelas_id
                    );


                }
            );


        }







        // FILTER HUBUNGAN

        if($request->filled('hubungan')){


            $query->where(
                'hubungan',
                $request->hubungan
            );


        }







        $orangTuas = $query

            ->orderBy(
                'nama_orang_tua'
            )

            ->paginate(20)

            ->withQueryString();







        $kelas = Kelas::withCount('siswas')

            ->with('jurusan')

            ->orderBy(
                'nama_kelas'
            )

            ->get();








        return view(
            'admin.orangtua.index',
            compact(
                'orangTuas',
                'kelas'
            )
        );


    }









    /*
    |--------------------------------------------------------------------------
    | TAMBAH
    |--------------------------------------------------------------------------
    */

    public function create()
    {


        $siswas = Siswa::with('kelas')

            ->orderBy(
                'nama_siswa'
            )

            ->get();



        return view(
            'admin.orangtua.create',
            compact(
                'siswas'
            )
        );


    }









    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {


        $validated = $request->validate([


            'siswa_id'
            =>
            'required|exists:siswas,id',



            'nama_orang_tua'
            =>
            'required|string|max:255',



            'hubungan'
            =>
            'required|in:Ayah,Ibu,Wali',



            'no_hp'
            =>
            'nullable|string|max:30',



            'pekerjaan'
            =>
            'nullable|string|max:255',


        ]);






        $cek = OrangTua::where(
            'siswa_id',
            $request->siswa_id
        )

        ->where(
            'hubungan',
            $request->hubungan
        )

        ->exists();






        if($cek){


            return back()

                ->withInput()

                ->withErrors([

                    'hubungan'
                    =>
                    'Data '.$request->hubungan.' sudah tersedia.'

                ]);


        }






        OrangTua::create($validated);






        return redirect()

            ->route('orangtua.index')

            ->with(
                'success',
                'Data orang tua berhasil ditambahkan.'
            );


    }









    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {


        $orangTua = OrangTua::findOrFail($id);



        $siswas = Siswa::with('kelas')

            ->orderBy(
                'nama_siswa'
            )

            ->get();





        return view(
            'admin.orangtua.edit',
            compact(
                'orangTua',
                'siswas'
            )
        );


    }









    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request,$id)
    {


        $orangTua = OrangTua::findOrFail($id);




        $validated = $request->validate([


            'siswa_id'
            =>
            'required|exists:siswas,id',


            'nama_orang_tua'
            =>
            'required|string|max:255',


            'hubungan'
            =>
            'required|in:Ayah,Ibu,Wali',


            'no_hp'
            =>
            'nullable|string|max:30',


            'pekerjaan'
            =>
            'nullable|string|max:255',


        ]);







        $cek = OrangTua::where(
            'siswa_id',
            $request->siswa_id
        )

        ->where(
            'hubungan',
            $request->hubungan
        )

        ->where(
            'id',
            '!=',
            $id
        )

        ->exists();






        if($cek){


            return back()

                ->withInput()

                ->withErrors([

                    'hubungan'
                    =>
                    'Data '.$request->hubungan.' sudah tersedia.'

                ]);


        }






        $orangTua->update($validated);







        return redirect()

            ->route('orangtua.index')

            ->with(
                'success',
                'Data orang tua berhasil diperbarui.'
            );


    }









    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {


        $orangTua = OrangTua::findOrFail($id);



        $orangTua->delete();






        return redirect()

            ->route('orangtua.index')

            ->with(
                'success',
                'Data orang tua berhasil dihapus.'
            );


    }









    /*
    |--------------------------------------------------------------------------
    | IMPORT
    |--------------------------------------------------------------------------
    */

    public function import(Request $request)
    {


        $request->validate([


            'file'
            =>
            'required|mimes:xlsx,xls|max:5120'


        ]);






        Excel::import(

            new OrangTuaImport,

            $request->file('file')

        );







        return redirect()

            ->route('orangtua.index')

            ->with(
                'success',
                'Data orang tua berhasil diimport.'
            );


    }









    /*
    |--------------------------------------------------------------------------
    | DATA ORANG TUA PER KELAS
    |--------------------------------------------------------------------------
    */

    public function kelas(Request $request,$id)
    {


        $kelas = Kelas::with('jurusan')

            ->findOrFail($id);






        $query = OrangTua::with([
            'siswa.kelas'
        ])

        ->whereHas(
            'siswa',
            function($q) use ($id){

                $q->where(
                    'kelas_id',
                    $id
                );

            }
        );







        // SEARCH DALAM KELAS

        if($request->filled('search')){


            $search = $request->search;


            $query->where(function($q) use ($search){


                $q->where(
                    'nama_orang_tua',
                    'like',
                    "%{$search}%"
                )


                ->orWhereHas(
                    'siswa',
                    function($s) use ($search){


                        $s->where(
                            'nama_siswa',
                            'like',
                            "%{$search}%"
                        )


                        ->orWhere(
                            'nis',
                            'like',
                            "%{$search}%"
                        );


                    }
                );


            });


        }







        if($request->filled('hubungan')){


            $query->where(
                'hubungan',
                $request->hubungan
            );


        }







        $orangTuas = $query

            ->orderBy(
                'nama_orang_tua'
            )

            ->paginate(20)

            ->withQueryString();







        return view(
            'admin.orangtua.kelas',
            compact(
                'kelas',
                'orangTuas'
            )
        );


    }



}