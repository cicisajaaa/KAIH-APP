<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Membedakan Admin dan Orang Tua
            $table->string('role')
                ->default('admin')
                ->after('email');

            // Menghubungkan user dengan data orang tua
            $table->foreignId('orang_tua_id')
                ->nullable()
                ->after('role')
                ->constrained('orang_tua')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['orang_tua_id']);

            $table->dropColumn([
                'orang_tua_id',
                'role',
            ]);
        });
    }
};