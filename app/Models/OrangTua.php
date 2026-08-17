<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrangTua extends Model
{
    use HasFactory;

    protected $table = 'orang_tua';

    protected $fillable = [
        'siswa_id',
        'nama_orang_tua',
        'hubungan',
        'no_hp',
        'pekerjaan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'orang_tua_id');
    }
}