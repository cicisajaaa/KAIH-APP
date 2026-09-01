<?php

namespace App\Services;

use Carbon\Carbon;


class AngketService
{


    public function hitungSkor($data)
    {


        $skor = 0;



        /*
        |--------------------------------------------------------------------------
        | IBADAH 50 POINT
        |--------------------------------------------------------------------------
        */


        $ibadah = [

            'sholat_subuh',
            'sholat_dzuhur',
            'sholat_ashar',
            'sholat_magrib',
            'sholat_isya'

        ];



        foreach($ibadah as $item)
        {


            if(
                !empty($data[$item])
            )
            {

                $skor += 10;

            }

        }






        /*
        |--------------------------------------------------------------------------
        | BELAJAR 20 POINT
        |--------------------------------------------------------------------------
        */


        if(
            !empty($data['belajar'])
        )
        {

            $skor += 20;

        }







        /*
        |--------------------------------------------------------------------------
        | BANGUN PAGI 15 POINT
        |--------------------------------------------------------------------------
        */


        if(
            !empty($data['bangun_pagi'])
        )
        {


        $jam = Carbon::createFromFormat(
    'H:i',
    $data['bangun_pagi']
);



            if(
                $jam->hour >=4 &&
                $jam->hour <=5
            )
            {

                $skor +=15;

            }


            elseif(
                $jam->hour ==6 ||
                $jam->hour ==7
            )
            {

                $skor +=10;

            }


        }







        /*
        |--------------------------------------------------------------------------
        | TIDUR MALAM 15 POINT
        |--------------------------------------------------------------------------
        */


        if(
            !empty($data['tidur_malam'])
        )
        {


 $jam = Carbon::createFromFormat(
    'H:i',
    $data['tidur_malam']
);



            if(
                $jam->hour >=20 &&
                $jam->hour <=21
            )
            {

                $skor +=15;

            }


            elseif(
                $jam->hour ==22
            )
            {

                $skor +=10;

            }


            elseif(
                $jam->hour ==23
            )
            {

                $skor +=5;

            }


        }






        return min($skor,100);


    }








    public function kategori($skor)
    {


        if($skor >=80)
        {

            return 'Baik';

        }


        elseif($skor >=60)
        {

            return 'Perlu Perhatian';

        }


        return 'Perlu Pendampingan';


    }









    public function rincianSkor($data)
    {


        $rincian = [

            'Subuh'=>0,
            'Dzuhur'=>0,
            'Ashar'=>0,
            'Magrib'=>0,
            'Isya'=>0,
            'Belajar'=>0,
            'Bangun Pagi'=>0,
            'Tidur Malam'=>0,

        ];





        $ibadah = [

            'sholat_subuh'=>'Subuh',
            'sholat_dzuhur'=>'Dzuhur',
            'sholat_ashar'=>'Ashar',
            'sholat_magrib'=>'Magrib',
            'sholat_isya'=>'Isya',

        ];





        foreach($ibadah as $field=>$label)
        {


            if(
                !empty($data[$field])
            )
            {

                $rincian[$label]=10;

            }

        }







        if(!empty($data['belajar']))
        {

            $rincian['Belajar']=20;

        }







        if(!empty($data['bangun_pagi']))
        {


            $jam=Carbon::parse(
                $data['bangun_pagi']
            );



            if(
                $jam->hour>=4 &&
                $jam->hour<=5
            )
            {

                $rincian['Bangun Pagi']=15;

            }


            elseif(
                $jam->hour==6 ||
                $jam->hour==7
            )
            {

                $rincian['Bangun Pagi']=10;

            }


        }







        if(!empty($data['tidur_malam']))
        {


            $jam=Carbon::parse(
                $data['tidur_malam']
            );



            if(
                $jam->hour>=20 &&
                $jam->hour<=21
            )
            {

                $rincian['Tidur Malam']=15;

            }


            elseif(
                $jam->hour==22
            )
            {

                $rincian['Tidur Malam']=10;

            }


            elseif(
                $jam->hour==23
            )
            {

                $rincian['Tidur Malam']=5;

            }


        }





        return $rincian;


    }



}