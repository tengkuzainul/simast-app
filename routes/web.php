<?php

use App\Http\Controllers\DataLaporan\LaporanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManjamenStok\TransaksiStokController;
use App\Http\Controllers\MasterData\BarangController;
use App\Http\Controllers\MasterData\KategoriBarangController;
use App\Http\Controllers\MasterData\PemasokController;
use App\Http\Controllers\UserController;
use App\Models\Notifikasi;
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

Route::get('/notifikasi/latest', function () {
    $user = Auth::user();

    $notifs = Notifikasi::where('target_role', $user->role)
        ->where('status', 'Unread')
        ->latest()
        ->take(5)
        ->get();

    return response()->json($notifs);
})->middleware('auth');

Route::put('/notifikasi/read/{id}', function ($id) {
    $notif = Notifikasi::findOrFail($id);

    if (Auth::user()->role === $notif->target_role) {
        $notif->status = 'read';
        $notif->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 403);
})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    /**
     * Route group role Owner
     */
    Route::middleware(['assignRole:Owner'])->group(function () {
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
         * Route Transaksi Stok
         */
        Route::controller(TransaksiStokController::class)->prefix('manajemen-stok')->group(function () {
            Route::put('/confirmed/{transaksi}', 'konfirmasiStatus')->name('stok.status');
            Route::delete('/destroy/{transaksi}', 'destroy')->name('stok.destroy');
        });
        /**
         * Route Kategori Barang
         */
        Route::controller(KategoriBarangController::class)->prefix('kategori')->group(function () {
            Route::delete('/destroy/{kategori}', 'destroy')->name('kategori.destroy');
        });
        /**
         * Route Barang
         */
        Route::controller(BarangController::class)->prefix('barang')->group(function () {
            Route::delete('/destroy/{barang}', 'destroy')->name('barang.destroy');
        });
        /**
         * Route Pemasok
         */
        Route::controller(PemasokController::class)->prefix('pemasok')->group(function () {
            Route::delete('/destroy/{pemasok}', 'destroy')->name('pemasok.destroy');
        });
        /**
         * Route Data Laporan
         */
        Route::controller(LaporanController::class)->prefix('laporan')->group(function () {
            Route::get('/form', 'getFormLaporan')->name('laporan.form');
            Route::post('/rekap', 'rekapLaporan')->name('laporan.rekap');
        });
    });

    /**
     * Route group role Operator Gudang Dan Owner
     */
    Route::middleware(['assignRole:Op-Gudang|Owner'])->group(function () {
        /**
         * Route Data Transaksi Stok
         */
        Route::controller(TransaksiStokController::class)->prefix('manajemen-stok')->group(function () {
            Route::get('/data', 'index')->name('stok.index');
        });
        /**
         * Route Kategori Barang
         */
        Route::controller(KategoriBarangController::class)->prefix('kategori')->group(function () {
            Route::get('/data', 'index')->name('kategori.index');
            Route::post('/store', 'store')->name('kategori.store');
            Route::put('/update/{kategori}', 'update')->name('kategori.update');
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
        });
        /**
         * Route Pemasok
         */
        Route::controller(PemasokController::class)->prefix('pemasok')->group(function () {
            Route::get('/data', 'index')->name('pemasok.index');
            Route::post('/store', 'store')->name('pemasok.store');
            Route::put('/update/{pemasok}', 'update')->name('pemasok.update');
        });
    });

    /**
     * Route group role Operator Gudang
     */
    Route::middleware(['assignRole:Op-Gudang|Owner'])->group(function () {
        /**
         * Route Data Transaksi Stok
         */
        Route::controller(TransaksiStokController::class)->prefix('manajemen-stok')->group(function () {
            Route::get('/form', 'formTransaksiStok')->name('stok.form');
            Route::post('/submit-form', 'transactionCreate')->name('stok.submit');
            Route::get('/edit/{transaksi}', 'edit')->name('stok.edit');
            Route::put('/update/{transaksi}', 'update')->name('stok.update');
        });
    });
});
