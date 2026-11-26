<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

// NABIL (MODUL A)
Route::get('/', fn () => redirect()->route('buku.index'));
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('buku', BukuController::class)->except(['index', 'show']);
});
Route::middleware('auth')->group(function () {
    Route::resource('buku', BukuController::class)->only(['index', 'show']);
});