<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class DataAnakController extends Controller
{

    public function index()
    {

        $orangTua = Auth::user()
            ->orangTua()
            ->with([
                'siswa.kelas.jurusan'
            ])
            ->first();


        if(!$orangTua){
            abort(403);
        }


        return view(
            'orangtua.data-anak',
            compact('orangTua')
        );

    }

}