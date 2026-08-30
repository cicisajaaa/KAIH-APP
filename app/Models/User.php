<?php

namespace App\Models;


use Database\Factories\UserFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;



class User extends Authenticatable
{

    use HasFactory, Notifiable;





    protected $fillable = [

        'name',

        'email',

        'password',

        'role',

        'orang_tua_id',

        'must_change_password',

    ];







    protected $hidden = [

        'password',

        'remember_token',

    ];









    /*
    |--------------------------------------------------------------------------
    | Relasi Orang Tua
    |--------------------------------------------------------------------------
    |
    | Satu akun login dimiliki oleh satu orang tua
    |
    */


    public function orangTua()
    {

        return $this->belongsTo(

            OrangTua::class,

            'orang_tua_id'

        );

    }









    /*
    |--------------------------------------------------------------------------
    | Helper Role
    |--------------------------------------------------------------------------
    */


    public function isAdmin()
    {

        return $this->role === 'admin';

    }






    public function isOrangTua()
    {

        return $this->role === 'orang_tua';

    }









    /*
    |--------------------------------------------------------------------------
    | Helper Password
    |--------------------------------------------------------------------------
    |
    | Mengecek apakah akun harus mengganti password
    |
    */


    public function harusGantiPassword()
    {

        return $this->must_change_password === true;

    }








protected function casts(): array
{

    return [

        'email_verified_at' => 'datetime',

        'must_change_password' => 'boolean',

    ];

}


}