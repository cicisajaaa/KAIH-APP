<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


use App\Http\Controllers\ProfileController;


// ADMIN
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\OrangTuaController;
use App\Http\Controllers\Admin\AngketController as AdminAngketController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\AkunOrangTuaController;
use App\Http\Controllers\Admin\MonitoringAngketController;


// ORANG TUA
use App\Http\Controllers\OrangTua\DashboardController as OrangTuaDashboardController;
use App\Http\Controllers\OrangTua\AngketController;
use App\Http\Controllers\OrangTua\DataAnakController;
use App\Http\Controllers\OrangTua\PasswordController;



/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return view('welcome');

});





/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {


    $user = Auth::user();



    if($user->role === 'admin')
    {

        return redirect()
            ->route('admin.dashboard');

    }



    if($user->role === 'orang_tua')
    {

        return redirect()
            ->route('orangtua.dashboard');

    }



    abort(403);



})
->middleware(['auth','verified'])
->name('dashboard');







/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {


    Auth::logout();


    request()
        ->session()
        ->invalidate();



    request()
        ->session()
        ->regenerateToken();



    return redirect()
        ->route('login');


})
->middleware('auth')
->name('logout');









/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/


Route::middleware([
    'auth',
    'role:admin'
])
->prefix('admin')
->group(function () {



    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/dashboard',
        [
            AdminDashboardController::class,
            'index'
        ]
    )
    ->name('admin.dashboard');





    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/laporan',
        [
            LaporanController::class,
            'index'
        ]
    )
    ->name('laporan.index');



    Route::get(
        '/laporan/export',
        [
            LaporanController::class,
            'export'
        ]
    )
    ->name('laporan.export');



/*
|--------------------------------------------------------------------------
| Monitoring Angket
|--------------------------------------------------------------------------
*/


Route::get(
    '/monitoring-angket',
    [
        MonitoringAngketController::class,
        'index'
    ]
)
->name('monitoring.angket');

Route::get(
    '/monitoring-angket/{siswa}',
    [
        MonitoringAngketController::class,
        'detail'
    ]
)
->name('monitoring.angket.detail');


    /*
    |--------------------------------------------------------------------------
    | Akun Orang Tua
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/generate-akun-orangtua',
        [
            AkunOrangTuaController::class,
            'generate'
        ]
    )
    ->name('admin.generate.orangtua');




    Route::get(
        '/akun-orangtua',
        [
            AkunOrangTuaController::class,
            'index'
        ]
    )
    ->name('admin.akun.orangtua');




    Route::post(
        '/akun-orangtua/{id}/reset-password',
        [
            AkunOrangTuaController::class,
            'resetPassword'
        ]
    )
    ->name('admin.akun.orangtua.reset');







    /*
    |--------------------------------------------------------------------------
    | Angket
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/angket',
        [
            AdminAngketController::class,
            'index'
        ]
    )
    ->name('angket.index');

Route::get(
    '/angket/{id}',
    [
        AdminAngketController::class,
        'detail'
    ]
)
->name('admin.angket.detail');






    /*
    |--------------------------------------------------------------------------
    | Master Data
    |--------------------------------------------------------------------------
    */



    Route::resource(
        '/jurusan',
        JurusanController::class
    )
    ->names('jurusan');




    Route::get(
        '/kelas/export',
        [
            KelasController::class,
            'export'
        ]
    )
    ->name('kelas.export');



    Route::post(
        '/kelas/import',
        [
            KelasController::class,
            'import'
        ]
    )
    ->name('kelas.import');



    Route::resource(
        '/kelas',
        KelasController::class
    )
    ->names('kelas');







    /*
    |--------------------------------------------------------------------------
    | Siswa
    |--------------------------------------------------------------------------
    */



    Route::resource(
        '/siswa',
        SiswaController::class
    )
    ->names('siswa');



    Route::post(
        '/siswa/import',
        [
            SiswaController::class,
            'import'
        ]
    )
    ->name('siswa.import');



    Route::get(
        '/siswa/export',
        [
            SiswaController::class,
            'export'
        ]
    )
    ->name('siswa.export');








    /*
    |--------------------------------------------------------------------------
    | Orang Tua
    |--------------------------------------------------------------------------
    */



    Route::resource(
        '/orang-tua',
        OrangTuaController::class
    )
    ->names('orangtua');



});









/*
|--------------------------------------------------------------------------
| ORANG TUA
|--------------------------------------------------------------------------
*/


Route::middleware([
    'auth',
    'role:orang_tua',
    'password.change'
])
->prefix('orang-tua')
->group(function () {




    /*
    |--------------------------------------------------------------------------
    | Ganti Password Pertama
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/ganti-password',
        [
            PasswordController::class,
            'edit'
        ]
    )
    ->name('orangtua.password.edit');




    Route::post(
        '/ganti-password',
        [
            PasswordController::class,
            'update'
        ]
    )
    ->name('orangtua.password.update');







    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/dashboard',
        [
            OrangTuaDashboardController::class,
            'index'
        ]
    )
    ->name('orangtua.dashboard');







    /*
    |--------------------------------------------------------------------------
    | Data Anak
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/data-anak',
        [
            DataAnakController::class,
            'index'
        ]
    )
    ->name('orangtua.data-anak');







    /*
    |--------------------------------------------------------------------------
    | Angket
    |--------------------------------------------------------------------------
    */


    Route::get(
        '/angket',
        [
            AngketController::class,
            'index'
        ]
    )
    ->name('orangtua.angket.index');




    Route::get(
        '/angket/create',
        [
            AngketController::class,
            'create'
        ]
    )
    ->name('orangtua.angket.create');




    Route::post(
        '/angket',
        [
            AngketController::class,
            'store'
        ]
    )
    ->name('orangtua.angket.store');



});









/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/


Route::middleware('auth')
->group(function () {


    Route::get(
        '/profile',
        [
            ProfileController::class,
            'edit'
        ]
    )
    ->name('profile.edit');



    Route::patch(
        '/profile',
        [
            ProfileController::class,
            'update'
        ]
    )
    ->name('profile.update');



    Route::delete(
        '/profile',
        [
            ProfileController::class,
            'destroy'
        ]
    )
    ->name('profile.destroy');


});








require __DIR__.'/auth.php';