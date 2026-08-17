<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Mencegah nama kelas yang sama
        Schema::table('kelas', function (Blueprint $table) {
            $table->unique(
                'nama_kelas',
                'kelas_nama_kelas_unique'
            );
        });

        // Mencegah NIS siswa yang sama
        Schema::table('siswas', function (Blueprint $table) {
            $table->unique(
                'nis',
                'siswas_nis_unique'
            );
        });

        // Satu siswa tidak boleh punya
        // hubungan yang sama lebih dari satu kali
        Schema::table('orang_tua', function (Blueprint $table) {
            $table->unique(
                ['siswa_id', 'hubungan'],
                'orang_tua_siswa_hubungan_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropUnique('kelas_nama_kelas_unique');
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->dropUnique('siswas_nis_unique');
        });

        Schema::table('orang_tua', function (Blueprint $table) {
            $table->dropUnique('orang_tua_siswa_hubungan_unique');
        });
    }
};