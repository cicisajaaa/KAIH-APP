<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrangTua;
use App\Models\User;
use Illuminate\Support\Str;


class CreateParentAccount extends Command
{

    protected $signature = 'orangtua:create-account';


    protected $description = 'Membuat akun login orang tua';



    public function handle()
    {

        $data = OrangTua::all();


        foreach($data as $ortu)
        {

            User::create([

                'orang_tua_id'=>$ortu->id,

                'name'=>$ortu->nama_orang_tua,


                'email'=>
                    Str::slug(
                        $ortu->nama_orang_tua
                    )
                    .$ortu->id
                    .'@kaih.app',


                'password'=>'orangtua123',


                'role'=>'orang_tua'

            ]);

        }


        $this->info(
            'Akun orang tua berhasil dibuat'
        );

    }

}