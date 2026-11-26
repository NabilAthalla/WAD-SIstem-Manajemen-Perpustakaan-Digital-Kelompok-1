<?php

use Illuminate\Support\Facades\Route;

// Halaman awal modul -> daftar anggota.
// (Jika digabung ke proyek tim, cukup tambahkan baris `require __DIR__ . '/anggota.php';`
//  ke web.php milik tim; route '/' tidak perlu dipakai.)
Route::redirect('/', '/members');

require __DIR__ . '/anggota.php';
