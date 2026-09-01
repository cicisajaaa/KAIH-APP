<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::table('angket_harian', function (Blueprint $table) {


            $table->text('alasan_tidak_sholat')
                ->nullable()
                ->after('sholat_isya');


        });


    }



    public function down(): void
    {

        Schema::table('angket_harian', function (Blueprint $table) {


            $table->dropColumn(
                'alasan_tidak_sholat'
            );


        });


    }

};