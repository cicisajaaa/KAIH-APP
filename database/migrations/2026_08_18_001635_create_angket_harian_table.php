<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('angket_harian', function (Blueprint $table) {
            $table->id();

            // Orang tua yang mengisi angket
            $table->foreignId('orang_tua_id')
                ->constrained('orang_tua')
                ->cascadeOnDelete();

            // Siswa/anak yang terkait
            $table->foreignId('siswa_id')
                ->constrained('siswas')
                ->cascadeOnDelete();

            // Tanggal angket
            $table->date('tanggal');

            // 1. Bangun pagi
            $table->time('bangun_pagi')->nullable();

            // 2. Sholat Subuh
            $table->boolean('sholat_subuh')->nullable();

            // 3. Sholat Ashar
            $table->boolean('sholat_ashar')->nullable();

            // 4. Membantu orang tua / masyarakat
            $table->text('kegiatan_membantu')->nullable();

            // 5. Sholat Magrib
            $table->boolean('sholat_magrib')->nullable();

            // 6. Sholat Isya
            $table->boolean('sholat_isya')->nullable();

            // 7. Belajar
            $table->boolean('belajar')->nullable();

            // 8. Tidur malam
            $table->time('tidur_malam')->nullable();

            $table->timestamps();

            // Satu siswa hanya punya satu angket untuk satu tanggal
            $table->unique(
                ['siswa_id', 'tanggal'],
                'angket_harian_siswa_tanggal_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('angket_harian');
    }
};