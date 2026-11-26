<?php

use App\Http\Controllers\Api\PublisherApiController;
use Illuminate\Support\Facades\Route;

// Otomatis berawalan /api, jadi alamat lengkapnya:
//   GET /api/publishers        -> semua penerbit (bisa difilter ?wilayah=Jawa Barat)
//   GET /api/publishers/{id}   -> satu penerbit
Route::get('/publishers', [PublisherApiController::class, 'index']);
Route::get('/publishers/{id}', [PublisherApiController::class, 'show']);
