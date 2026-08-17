<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\OrangTuaController;
use App\Http\Controllers\OrangTua\DashboardController as OrangTuaDashboardController;


/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});


/*
|--------------------------------------------------------------------------
| Dashboard Redirect
|--------------------------------------------------------------------------
|
| Setelah login, route /dashboard akan mengarahkan user
| berdasarkan role akun.
|
*/

Route::get('/dashboard', function () {

    $user = Auth::user();

    if ($user->role === 'orang_tua') {
        return redirect()->route('orangtua.dashboard');
    }

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    abort(403, 'Role akun tidak dikenali.');

})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');

})->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
|
| Semua route di dalam group ini hanya bisa diakses oleh:
| role = admin
|
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard Admin
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | Jurusan
        |--------------------------------------------------------------------------
        */

        Route::resource('/jurusan', JurusanController::class)
            ->names('jurusan');


        /*
        |--------------------------------------------------------------------------
        | Kelas
        |--------------------------------------------------------------------------
        */

        Route::get('/kelas/export', [KelasController::class, 'export'])
            ->name('kelas.export');

        Route::post('/kelas/import', [KelasController::class, 'import'])
            ->name('kelas.import');

        Route::resource('/kelas', KelasController::class)
            ->names('kelas');


        /*
        |--------------------------------------------------------------------------
        | Siswa
        |--------------------------------------------------------------------------
        */

        Route::get('/siswa', [SiswaController::class, 'index'])
            ->name('siswa.index');

        Route::get('/siswa/create', [SiswaController::class, 'create'])
            ->name('siswa.create');

        Route::post('/siswa', [SiswaController::class, 'store'])
            ->name('siswa.store');

        Route::post('/siswa/import', [SiswaController::class, 'import'])
            ->name('siswa.import');

        Route::get('/siswa/export', [SiswaController::class, 'export'])
            ->name('siswa.export');

        Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])
            ->name('siswa.edit');

        Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])
            ->name('siswa.update');

        Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])
            ->name('siswa.destroy');


        /*
        |--------------------------------------------------------------------------
        | Orang Tua
        |--------------------------------------------------------------------------
        */

        Route::get('/orang-tua', [OrangTuaController::class, 'index'])
            ->name('orangtua.index');

        Route::get('/orang-tua/create', [OrangTuaController::class, 'create'])
            ->name('orangtua.create');

        Route::post('/orang-tua', [OrangTuaController::class, 'store'])
            ->name('orangtua.store');

        Route::post('/orang-tua/import', [OrangTuaController::class, 'import'])
            ->name('orangtua.import');

        Route::get('/orang-tua/{id}/edit', [OrangTuaController::class, 'edit'])
            ->name('orangtua.edit');

        Route::put('/orang-tua/{id}', [OrangTuaController::class, 'update'])
            ->name('orangtua.update');

        Route::delete('/orang-tua/{id}', [OrangTuaController::class, 'destroy'])
            ->name('orangtua.destroy');
    });


/*
|--------------------------------------------------------------------------
| ORANG TUA
|--------------------------------------------------------------------------
|
| Dashboard ini hanya bisa diakses oleh:
| role = orang_tua
|
*/

Route::middleware(['auth', 'role:orang_tua'])
    ->group(function () {

        Route::get('/orang-tua/dashboard', [OrangTuaDashboardController::class, 'index'])
            ->name('orangtua.dashboard');
    });


/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
|
| Profile bisa diakses oleh user yang sudah login,
| baik admin maupun orang tua.
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';