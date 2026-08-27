<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::table('angket_harian', function (Blueprint $table) {

            $table->boolean('sholat_dzuhur')
                ->default(false)
                ->after('sholat_subuh');

        });

    }



    public function down(): void
    {

        Schema::table('angket_harian', function (Blueprint $table) {

            $table->dropColumn('sholat_dzuhur');

        });

    }

};