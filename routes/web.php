<?php

use App\Http\Controllers\HomeController;
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
