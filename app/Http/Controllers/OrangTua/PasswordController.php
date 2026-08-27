<?php

namespace App\Http\Controllers\OrangTua;


use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;




class PasswordController extends Controller
{



    public function edit()
    {


        return view(
            'orangtua.password.edit'
        );


    }









    public function update(
        Request $request
    )
    {


        $request->validate([


            'password' => [

                'required',

                'min:8',

                'confirmed'

            ]

        ]);







        $user = auth()->user();





        $user->update([


            'password'
            =>
            Hash::make(
                $request->password
            ),



            'must_change_password'
            =>
            false,


        ]);








        return redirect()

            ->route(
                'orangtua.dashboard'
            )

            ->with(
                'success',
                'Password berhasil diperbarui.'
            );


    }



}