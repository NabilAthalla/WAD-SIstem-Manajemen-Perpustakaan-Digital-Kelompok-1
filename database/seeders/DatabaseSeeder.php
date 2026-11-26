<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Password otomatis di-hash oleh cast 'hashed' di model User
        User::updateOrCreate(['email' => 'admin@literahub.test'], [
            'name' => 'Nabil Athalla', 'password' => 'admin123', 'role' => 'admin',
        ]);
        User::updateOrCreate(['email' => 'user@literahub.test'], [
            'name' => 'Pengguna Biasa', 'password' => 'user123', 'role' => 'pengguna',
        ]);

        foreach (['Teknologi', 'Sains', 'Sastra', 'Sejarah', 'Bisnis'] as $nama) {
            Kategori::firstOrCreate(['nama' => $nama]);
        }

        $buku = [
            ['9786020000011', 'Belajar Laravel', 'Budi Santoso', 'Informatika', 2023, 'Teknologi', 10],
            ['9786020000028', 'Dasar-Dasar Basis Data', 'Siti Aminah', 'Andi Publisher', 2021, 'Teknologi', 5],
            ['9786020000035', 'Sejarah Nusantara', 'Ahmad Fauzi', 'Gramedia', 2019, 'Sejarah', 7],
            ['9786020000042', 'Laskar Pelangi', 'Andrea Hirata', 'Bentang', 2005, 'Sastra', 3],
        ];

        foreach ($buku as [$isbn, $judul, $penulis, $penerbit, $tahun, $kategori, $stok]) {
            Buku::firstOrCreate(['isbn' => $isbn], [
                'judul' => $judul,
                'penulis' => $penulis,
                'penerbit' => $penerbit,
                'tahun' => $tahun,
                'kategori_id' => Kategori::where('nama', $kategori)->value('id'),
                'stok' => $stok,
            ]);
        }
    }
}