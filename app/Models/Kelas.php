<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;


    protected $table = 'kelas';


    protected $fillable = [
        'nama_kelas',
        'jurusan_id',
    ];



    /**
     * Kelas memiliki banyak siswa.
     */
    public function siswas()
    {
        return $this->hasMany(
            Siswa::class,
            'kelas_id'
        );
    }



    /**
     * Relasi ke jurusan.
     */
    public function jurusan()
    {
        return $this->belongsTo(
            Jurusan::class,
            'jurusan_id'
        );
    }

}