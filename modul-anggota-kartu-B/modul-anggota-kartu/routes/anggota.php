<?php

/*
|--------------------------------------------------------------------------
| Route Modul Anggota & Kartu (LiteraHub)
|--------------------------------------------------------------------------
| Tanpa login/register (autentikasi ditangani modul lain / tim).
| File ini di-include dari routes/web.php:
|     require __DIR__ . '/anggota.php';
*/

use App\Http\Controllers\Api\MemberController as ApiMemberController;
use App\Http\Controllers\Api\MembershipTypeController as ApiMembershipTypeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MembershipTypeController;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\Route;

// ---------- Halaman web ----------
// Cetak kartu harus dideklarasikan SEBELUM resource agar tidak tertangkap {member}.
Route::get('/members/{member}/card', [MemberController::class, 'card'])->name('members.card');
Route::resource('members', MemberController::class);
Route::resource('membership-types', MembershipTypeController::class)->except(['show']);

// ---------- REST API (prefix /api, tanpa token) ----------
// CSRF dimatikan khusus API karena route ini dimuat lewat web.php (klien API tidak punya token CSRF).
Route::prefix('api')->middleware('api')->withoutMiddleware([ValidateCsrfToken::class])->group(function () {
    Route::apiResource('members', ApiMemberController::class)->names('api.members');
    Route::apiResource('membership-types', ApiMembershipTypeController::class)
        ->only(['index', 'show'])
        ->names('api.membership-types');
});
