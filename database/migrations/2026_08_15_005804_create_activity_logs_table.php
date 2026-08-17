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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        
        // Menggunakan kolom biasa tanpa relasi strict dulu
        $table->unsignedBigInteger('student_id');

        $table->date('date');
        $table->time('wake_up_time')->nullable();
        $table->boolean('subuh')->default(false);
        $table->boolean('ashar')->default(false);
        $table->text('help_parents')->nullable();
        $table->boolean('maghrib')->default(false);
        $table->boolean('isya')->default(false);
        $table->boolean('study')->default(false);
        $table->time('sleep_time')->nullable();
        $table->timestamps();
    });
}
};