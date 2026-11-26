# LiteraHub - Sistem Manajemen Perpustakaan Digital

Tugas Studi Kasus 01 (Web Application Development), Kelompok 1.

Branch `nabil` berisi Modul A (Katalog & Buku), dikerjakan oleh Nabil Athalla (102022300363). Modul lain (Anggota & Kartu, Penerbit & Supplier, Fasilitas & Area) dikerjakan anggota kelompok lain di branch masing-masing.

## Tentang modul ini

Modul A dipakai untuk mengelola data buku: judul, ISBN, penulis, penerbit, tahun terbit, kategori, stok, jumlah halaman, deskripsi, dan cover. Ada pencarian berdasarkan judul atau penulis, dan daftar buku dibagi per 10 data.

Catatan soal desain:

- Kategori disimpan di tabel sendiri (`kategoris`) dan dihubungkan ke buku lewat `kategori_id`.
- Penerbit sengaja hanya kolom teks di tabel `bukus`, karena data penerbit ada di Modul C dan modul ini tidak boleh bergantung ke modul lain.
- Ada dua peran. Admin bisa tambah, ubah, dan hapus buku. Pengguna hanya bisa melihat daftar dan detail buku.

## Yang dipakai

- PHP 8.2 atau lebih baru
- Composer
- Laravel
- SQLite (bawaan Laravel, tidak perlu setting database tambahan)
- Bootstrap 5
- Laravel Sanctum untuk token API

## Cara menjalankan

```bash
git clone https://github.com/NabilAthalla/WAD-SIstem-Manajemen-Perpustakaan-Digital-Kelompok-1.git
cd WAD-SIstem-Manajemen-Perpustakaan-Digital-Kelompok-1
git checkout nabil

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Lalu buka http://127.0.0.1:8000

Kalau mau pakai MySQL, ubah bagian `DB_` di file `.env` dan buat databasenya dulu sebelum menjalankan `php artisan migrate --seed`.

## Akun untuk mencoba

Akun ini dibuat oleh seeder.

| Peran    | Email                | Password |
|----------|----------------------|----------|
| Admin    | admin@literahub.test | admin123 |
| Pengguna | user@literahub.test  | user123  |

Saat login, pilih peran di dropdown "Login sebagai". Peran yang dipilih harus sama dengan peran akunnya, kalau tidak login ditolak. Orang yang daftar lewat halaman register otomatis menjadi pengguna biasa. Akun admin hanya bisa dibuat lewat seeder atau langsung di database.

## API

Base URL: `http://127.0.0.1:8000/api`

| Method | Endpoint     | Keterangan                   | Akses  |
|--------|--------------|------------------------------|--------|
| POST   | /login       | Login, mengembalikan token   | Publik |
| GET    | /buku        | Daftar buku (bisa `?q=kata`) | Publik |
| GET    | /buku/{id}   | Detail satu buku             | Publik |
| POST   | /buku        | Tambah buku                  | Admin  |
| PUT    | /buku/{id}   | Ubah buku                    | Admin  |
| DELETE | /buku/{id}   | Hapus buku                   | Admin  |
| POST   | /logout      | Hapus token                  | Admin  |

Untuk endpoint admin, login dulu untuk ambil token:

```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Accept: application/json" \
  -d "email=admin@literahub.test" \
  -d "password=admin123"
```

Lalu kirim token itu di header setiap request:

```
Authorization: Bearer <token>
Accept: application/json
```

Contoh body untuk POST /buku:

```json
{
  "judul": "Belajar Laravel",
  "isbn": "9786020000099",
  "penulis": "Budi Santoso",
  "penerbit": "Informatika",
  "tahun": 2023,
  "kategori_id": 1,
  "stok": 5
}
```

Kalau validasi gagal, API membalas kode 422 beserta pesan kesalahannya. Kalau yang mengakses endpoint admin bukan admin, balasannya 403.

## Struktur penting

```
app/Http/Controllers/BukuController.php         controller halaman web
app/Http/Controllers/Api/BukuApiController.php  controller API
app/Http/Middleware/AdminMiddleware.php         pembatas akses admin
app/Models/Buku.php, Kategori.php, User.php
database/migrations/                            struktur tabel
database/seeders/DatabaseSeeder.php             akun dan data contoh
resources/views/buku/                           tampilan katalog
routes/web.php, routes/api.php
```

## Catatan

- Cover buku disimpan di `storage/app/public/covers`, jadi `php artisan storage:link` perlu dijalankan sekali.
- File `.env` tidak saya push ke GitHub.