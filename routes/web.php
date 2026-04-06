<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/daftar', [AuthController::class, 'showDaftar'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'daftar'])->name('daftar.submit');

Route::get('/index', function () {
    if (!session('user_id')) {
        return redirect()->route('login');
    }
    return view('index');
})->name('index');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
