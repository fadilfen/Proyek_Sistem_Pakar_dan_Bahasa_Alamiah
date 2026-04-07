<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GejalaController;
use App\Http\Controllers\Admin\PenyakitController;
use App\Http\Controllers\Admin\RulesController;

// Halaman utama → Login
Route::get('/', [AuthController::class, 'showLogin'])->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/daftar', [AuthController::class, 'showDaftar'])->name('daftar');
Route::post('/daftar', [AuthController::class, 'daftar'])->name('daftar.submit');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Diagnosa routes (protected)
Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa');
Route::post('/diagnosa', [DiagnosaController::class, 'proses'])->name('diagnosa.proses');

// Riwayat routes (protected)
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
Route::get('/riwayat/{id}', [RiwayatController::class, 'detail'])->name('riwayat.detail');

// Admin routes (protected)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // CRUD Gejala
    Route::resource('gejala', GejalaController::class);
    
    // CRUD Penyakit
    Route::resource('penyakit', PenyakitController::class);
    
    // CRUD Rules
    Route::resource('rules', RulesController::class);
});

