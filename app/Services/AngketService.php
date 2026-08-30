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
        | IBADAH (50 POIN)
        |--------------------------------------------------------------------------
        */


        $skor += !empty($data['sholat_subuh'])
            ? 10
            : 0;


        $skor += !empty($data['sholat_dzuhur'])
            ? 10
            : 0;


        $skor += !empty($data['sholat_ashar'])
            ? 10
            : 0;


        $skor += !empty($data['sholat_magrib'])
            ? 10
            : 0;


        $skor += !empty($data['sholat_isya'])
            ? 10
            : 0;







        /*
        |--------------------------------------------------------------------------
        | BELAJAR (20 POIN)
        |--------------------------------------------------------------------------
        */


        $skor += !empty($data['belajar'])
            ? 20
            : 0;








        /*
        |--------------------------------------------------------------------------
        | BANGUN PAGI (15 POIN)
        |--------------------------------------------------------------------------
        */


        if(!empty($data['bangun_pagi']))
        {


            $jam = Carbon::parse(
                $data['bangun_pagi']
            );



            // Bangun jam 04.00 - 05.59

            if(
                $jam->hour >= 4 &&
                $jam->hour <= 5
            )
            {

                $skor += 15;

            }



            // Bangun jam 06.00 - 07.59

            elseif(
                $jam->hour >= 6 &&
                $jam->hour <= 7
            )
            {

                $skor += 10;

            }


        }








        /*
        |--------------------------------------------------------------------------
        | TIDUR MALAM (15 POIN)
        |--------------------------------------------------------------------------
        */


        if(!empty($data['tidur_malam']))
        {


            $jam = Carbon::parse(
                $data['tidur_malam']
            );



            // Tidur jam 20.00 - 21.59

            if(
                $jam->hour >= 20 &&
                $jam->hour <= 21
            )
            {

                $skor += 15;

            }



            // Tidur jam 22.00

            elseif(
                $jam->hour == 22
            )
            {

                $skor += 10;

            }


        }







        return $skor;


    }








    public function kategori($skor)
    {


        if($skor >= 80)
        {

            return "Baik";

        }


        elseif($skor >= 50)
        {

            return "Perlu Perhatian";

        }


        else
        {

            return "Perlu Pendampingan";

        }


    }



}