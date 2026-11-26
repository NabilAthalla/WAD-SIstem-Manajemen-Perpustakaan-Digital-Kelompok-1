<?php

namespace Database\Seeders;

use App\Models\Publisher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun untuk login: admin@intelu.test / password
        User::create([
            'name'     => 'Admin LiteraHub',
            'email'    => 'admin@intelu.test',
            'password' => Hash::make('password'),
        ]);

        // Data contoh penerbit
        Publisher::create([
            'nama_penerbit' => 'Gramedia Pustaka Utama',
            'kontak_sales'  => '0812-1111-2222',
            'alamat'        => 'Jl. Palmerah Barat No. 29, Jakarta',
            'wilayah_asal'  => 'DKI Jakarta',
        ]);
        Publisher::create([
            'nama_penerbit' => 'Informatika Bandung',
            'kontak_sales'  => '0857-5555-6666',
            'alamat'        => 'Jl. Rancaekek Kencana No. 12, Bandung',
            'wilayah_asal'  => 'Jawa Barat',
        ]);
    }
}
