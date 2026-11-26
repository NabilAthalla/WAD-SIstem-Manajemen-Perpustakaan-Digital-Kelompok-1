# LiteraHub - Modul Anggota & Kartu (Individu B)

LiteraHub adalah Sistem Manajemen Perpustakaan Digital (Studi Kasus 01 - Pengembangan Aplikasi Web, Laravel MVC).

Cakupan modul: pengelolaan profil anggota perpustakaan, nomor kartu (otomatis), tipe keanggotaan, dan cetak ID card.

## Fitur

- CRUD Anggota (form & tabel), pencarian, filter status & tipe, pagination
- CRUD Tipe Keanggotaan (tipe yang masih dipakai anggota tidak bisa dihapus)
- Nomor kartu otomatis (`LIByyNNNNN`) dan masa berlaku otomatis (tanggal daftar + durasi tipe)
- Cetak ID Card (`/members/{id}/card`, siap print)
- RESTful API (`/api/...`, tanpa token)
- Feature test (`tests/Feature/MemberModuleTest.php`)

## Cara tercepat: skrip pemasang

Kesalahan umum: isi modul ikut ter-upload **ke dalam subfolder** repo
(mis. `modul-anggota-kartu/routes/web.php`), bukan ke root Laravel, sehingga route `/members`
tidak pernah terdaftar. Gunakan skrip ini dari folder modul:

```bash
bash pasang-modul.sh /path/ke/root-laravel-tim   # root = folder yang berisi file `artisan`
```

Skrip menyalin file ke lokasi yang benar dan menambahkan `require __DIR__ . '/anggota.php';`
ke `routes/web.php` tim tanpa menimpanya. Setelah itu jalankan `php artisan migrate` dan seeder.

**Cek di GitHub:** file route harus berada di `routes/anggota.php` pada root repo
(bukan `modul-.../routes/...`). Setelah merge, jalankan `git pull` lalu `php artisan route:list --name=members`.

## Cara memasang (Laravel 11 / 12, PHP 8.2+)

Folder ini berisi file modul saja (bukan seluruh framework). **Tidak ada login/register** - autentikasi diurus modul/tim lain.

### A. Digabung ke proyek tim (repo GitHub kelompok)

1. Salin isi folder modul ke root proyek, **kecuali** `routes/web.php` (jangan menimpa milik tim):
   - `app/`, `database/`, `resources/views/members`, `resources/views/membership-types`, `resources/views/layouts/app.blade.php` (opsional, kalau tim sudah punya layout sendiri ganti `@extends('layouts.app')` di view modul), `routes/anggota.php`, `tests/`
2. Buka `routes/web.php` milik tim, tambahkan **satu baris** di bagian bawah:

   ```php
   require __DIR__ . '/anggota.php';
   ```
3. Jalankan:

   ```bash
   php artisan migrate
   php artisan db:seed --class=MembershipTypeSeeder
   php artisan db:seed --class=MemberSeeder
   php artisan route:list --name=members   # cek route sudah terdaftar
   php artisan serve
   ```
4. Buka http://127.0.0.1:8000/members

### B. Proyek Laravel baru (mandiri)

```bash
composer create-project laravel/laravel perpustakaan-anggota
cd perpustakaan-anggota
# salin SEMUA isi folder modul ke sini (boleh menimpa routes/web.php)
php artisan migrate
php artisan db:seed --class=MembershipTypeSeeder
php artisan db:seed --class=MemberSeeder
php artisan test
php artisan serve
```

Buka http://127.0.0.1:8000 (otomatis menuju `/members`).

## Daftar route web

| Method | URL | Nama |
|---|---|---|
| GET | `/members` | members.index |
| GET | `/members/create` | members.create |
| POST | `/members` | members.store |
| GET | `/members/{member}` | members.show |
| GET | `/members/{member}/edit` | members.edit |
| PUT/PATCH | `/members/{member}` | members.update |
| DELETE | `/members/{member}` | members.destroy |
| GET | `/members/{member}/card` | members.card |
| GET | `/membership-types` (+ `create`, `{id}/edit`, POST, PUT, DELETE) | membership-types.* |

## Endpoint API

Tanpa autentikasi. Kirim header `Accept: application/json`.

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/members` | Daftar anggota (`?search=`, `?status=`, `?membership_type_id=`, `?page=`) |
| POST | `/api/members` | Tambah anggota |
| GET | `/api/members/{id}` | Detail anggota |
| PUT/PATCH | `/api/members/{id}` | Ubah anggota |
| DELETE | `/api/members/{id}` | Hapus anggota |
| GET | `/api/membership-types` | Daftar tipe keanggotaan |
| GET | `/api/membership-types/{id}` | Detail tipe keanggotaan |

Contoh body `POST /api/members`:

```json
{
  "nama": "Budi Santoso",
  "email": "budi@example.com",
  "no_telepon": "081234567890",
  "alamat": "Bandung",
  "tanggal_lahir": "2003-04-12",
  "jenis_kelamin": "L",
  "membership_type_id": 1,
  "tanggal_daftar": "2026-10-21",
  "status": "aktif"
}
```

## Struktur database

- `membership_types`: id, nama, kode, durasi_bulan, maks_pinjam, biaya
- `members`: id, nomor_kartu, nama, email, no_telepon, alamat, tanggal_lahir, jenis_kelamin, membership_type_id (FK), tanggal_daftar, tanggal_berlaku, status
