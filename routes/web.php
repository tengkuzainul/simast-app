<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterData\BarangController;
use App\Http\Controllers\MasterData\KategoriBarangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes([
    'password.confirm' => false,
    'password.reset' => false,
    'password.request' => false,
    'password.email' => false,
    'register' => false,
    'verify' => false,
]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    /**
     * Route Data Pengguna
     */
    Route::controller(UserController::class)->prefix('user')->group(function () {
        Route::get('/data', 'index')->name('user.index');
        Route::get('/create', 'create')->name('user.create');
        Route::post('/store', 'store')->name('user.store');
        Route::get('/edit/{user}', 'edit')->name('user.edit');
        Route::put('/update/{user}', 'update')->name('user.update');
        Route::delete('/destroy/{user}', 'destroy')->name('user.destroy');
    });
    /**
     * Route Kategori Barang
     */
    Route::controller(KategoriBarangController::class)->prefix('kategori')->group(function () {
        Route::get('/data', 'index')->name('kategori.index');
        Route::post('/store', 'store')->name('kategori.store');
        Route::put('/update/{kategori}', 'update')->name('kategori.update');
        Route::delete('/destroy/{kategori}', 'destroy')->name('kategori.destroy');
    });
    /**
     * Route Barang
     */
    Route::controller(BarangController::class)->prefix('barang')->group(function () {
        Route::get('/data', 'index')->name('barang.index');
        Route::get('/create', 'create')->name('barang.create');
        Route::post('/store', 'store')->name('barang.store');
        Route::get('/edit/{barang}', 'edit')->name('barang.edit');
        Route::put('/update/{barang}', 'update')->name('barang.update');
        Route::delete('/destroy/{barang}', 'destroy')->name('barang.destroy');
    });
});
