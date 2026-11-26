<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BukuApiController;
use Illuminate\Support\Facades\Route;

// NABIL (MODUL A)
Route::post('/login', [AuthApiController::class, 'login']);
Route::get('/buku', [BukuApiController::class, 'index']);
Route::get('/buku/{buku}', [BukuApiController::class, 'show']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/buku', [BukuApiController::class, 'store']);
    Route::put('/buku/{buku}', [BukuApiController::class, 'update']);
    Route::delete('/buku/{buku}', [BukuApiController::class, 'destroy']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
});