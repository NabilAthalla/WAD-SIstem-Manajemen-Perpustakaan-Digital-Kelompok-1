<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;

// Halaman utama diarahkan ke daftar penerbit
Route::get('/', fn () => redirect()->route('publishers.index'));

// Login & logout
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// CRUD penerbit hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::resource('publishers', PublisherController::class)->except('show');
});
