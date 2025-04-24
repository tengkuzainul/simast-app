<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterData\KategoriBarangController;
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
     * Route Kategori Barang
     */
    Route::controller(KategoriBarangController::class)->prefix('kategori')->group(function () {
        Route::get('/data', 'index')->name('kategori.index');
        Route::post('/store', 'store')->name('kategori.store');
        Route::put('/update/{kategori}', 'update')->name('kategori.update');
        Route::delete('/destroy/{kategori}', 'destroy')->name('kategori.destroy');
    });
});
