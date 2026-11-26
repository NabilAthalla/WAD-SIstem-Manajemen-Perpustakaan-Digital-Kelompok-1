# Minggu 11-15: REST API JSON, Git Organisasi, Deployment (Modul C Penerbit & Supplier)

Dibuat untuk project Laravel `telyu` yang sudah ada (Laravel 13). Tidak perlu `php artisan install:api`
dan tidak ada paket tambahan yang perlu di-install.

## Bagian 1: REST API (1 endpoint JSON)

### Salin 3 file ke project `telyu` (pilih Replace)
| Dari folder ini | Ke project `telyu` |
|---|---|
| routes/api.php | routes/api.php (file baru) |
| app/Http/Controllers/Api/PublisherApiController.php | app/Http/Controllers/Api/ (folder baru) |
| bootstrap/app.php | bootstrap/app.php (hanya menambah 1 baris `api: ...`) |

Satu-satunya perubahan di `bootstrap/app.php` adalah baris ini di dalam `withRouting(...)`:
```php
api: __DIR__.'/../routes/api.php',
```
Jika `bootstrap/app.php` kamu sudah berubah, tambahkan baris itu secara manual daripada menimpa file.

### Cek dan coba
```
php artisan route:list --path=api
php artisan serve
```
Buka di browser:
- http://localhost:8000/api/publishers                      -> semua penerbit (JSON)
- http://localhost:8000/api/publishers/1                    -> satu penerbit
- http://localhost:8000/api/publishers/999                  -> JSON error 404
- http://localhost:8000/api/publishers?wilayah=Jawa Barat   -> filter wilayah

Endpoint hanya GET dan tanpa login, jadi aman dipamerkan saat online karena data tidak bisa diubah dari luar.
Tangkapan layar yang dikumpulkan: tampilan JSON di browser (URL terlihat) dengan tanggal dan waktu.

## Bagian 2: Git Organisasi (sesuai pengumuman dosen)
1. Repositori individu: set visibilitas **Public** (GitHub -> repo -> Settings -> General -> Danger Zone ->
   Change visibility), lalu kumpulkan tautannya lewat LMS.
2. Ketua tim menerima undangan ke organisasi **MK PAW 26/27** (cek email atau github.com/settings/organizations).
3. Transfer repositori tim ke organisasi: repo -> Settings -> Danger Zone -> **Transfer ownership** ->
   pilih organisasi.
4. Ganti nama repositori memakai format `Kelas_Tim_X_NamaApp`, misalnya `49-01_Tim_A_NakulaApp`:
   repo -> Settings -> General -> Repository name.
5. Setelah nama diganti, perbarui remote di komputer:
```
git remote set-url origin https://github.com/NAMA-ORG/NAMA-REPO-BARU.git
git remote -v
```
Jangan ikutkan file `.env` ke GitHub (sudah ada di `.gitignore` bawaan Laravel). Cek dengan `git status` sebelum commit.

## Bagian 3: Deployment ke hosting publik

PENTING: project ini memakai Laravel 13 yang membutuhkan **PHP 8.4.1 atau lebih baru**.
Pilih versi PHP 8.4 di pengaturan hosting (cPanel: "Select PHP Version" / "MultiPHP Manager").
Hosting yang hanya menyediakan PHP 8.3 atau lebih lama tidak akan bisa menjalankan project ini.

### 1. Siapkan project
1. Pastikan aplikasi jalan di komputer lokal.
2. Compress folder `telyu` menjadi ZIP. Folder `vendor` ikut jika hosting tidak punya Composer.
   Jangan ikutkan `node_modules` dan `.git`. Kosongkan `storage/logs`.

### 2. Database di hosting
1. Buat database, user, dan password di menu **MySQL Databases**. Catat juga **host**
   (kadang bukan `localhost`).
2. Di phpMyAdmin lokal, export database `db_telyu` (format SQL), lalu import di phpMyAdmin hosting.
   Tabel `sessions` ikut karena project memakai `SESSION_DRIVER=database`.

### 3. Upload
```
/home/user/
├── telyu/          <- semua isi project KECUALI folder public
└── public_html/    <- isi folder public/ (index.php, .htaccess, dll)
```
Edit `public_html/index.php` agar menunjuk ke folder `telyu`:
```php
require __DIR__.'/../telyu/vendor/autoload.php';
$app = require_once __DIR__.'/../telyu/bootstrap/app.php';
```
Jika ada baris `maintenance.php`, ubah juga menjadi `__DIR__.'/../telyu/storage/framework/maintenance.php'`.

### 4. `.env` di hosting (telyu/.env), jangan salin mentah dari lokal
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-kamu.com
DB_CONNECTION=mysql
DB_HOST=(host dari hosting)
DB_PORT=3306
DB_DATABASE=(nama database hosting)
DB_USERNAME=(user hosting)
DB_PASSWORD=(password hosting)
```
`APP_KEY` salin dari `.env` lokal. `APP_DEBUG=false` wajib di server publik.

### 5. Izin folder
`storage` dan `bootstrap/cache` harus bisa ditulis (permission 775).

### 6. Ganti password admin
Ganti password `admin@telyu.test` sebelum online (lewat Terminal cPanel jika ada):
```
php artisan tinker
App\Models\User::where('email','admin@telyu.test')->update(['password' => Hash::make('PasswordBaruYangKuat')]);
```

### 7. Tes setelah online
- https://domain-kamu.com/login        -> halaman login tampil
- https://domain-kamu.com/api/publishers -> JSON tampil
- Login, lalu tambah, edit, hapus penerbit

### Jika error
| Gejala | Penyebab umum |
|---|---|
| 500 / halaman putih | Versi PHP belum 8.4, `APP_KEY` kosong, atau path di `public_html/index.php` salah |
| 500 setelah upload | `storage` atau `bootstrap/cache` tidak bisa ditulis |
| 404 selain halaman utama | `.htaccess` dari folder `public` belum ikut dipindah |
| SQLSTATE access denied / connection refused | `DB_HOST`, `DB_USERNAME`, `DB_PASSWORD` tidak sesuai hosting |
| `/api/...` 404 | `routes/api.php` atau baris `api:` di `bootstrap/app.php` belum ada di server |

## Minggu 15-16
Live Code Session dan evaluasi tidak ada kode baru. Pahami alur: route -> controller -> model -> database ->
view/JSON, dan siapkan demo tambah, edit, hapus, login, dan endpoint API.
