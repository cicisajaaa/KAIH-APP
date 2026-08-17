<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orang_tua', function (Blueprint $table) {

            $table->id();

            // Terhubung ke siswa
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnDelete();

            $table->string('nama_orang_tua');

            $table->enum('hubungan', [
                'Ayah',
                'Ibu',
                'Wali'
            ]);

            $table->string('no_hp')->nullable();

            $table->string('pekerjaan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orang_tua');
    }
};