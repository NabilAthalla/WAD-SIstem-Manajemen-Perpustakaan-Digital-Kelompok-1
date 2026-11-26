<?php

namespace Database\Seeders;

use App\Models\MembershipType;
use Illuminate\Database\Seeder;

class MembershipTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['nama' => 'Mahasiswa', 'kode' => 'MHS', 'durasi_bulan' => 12, 'maks_pinjam' => 5, 'biaya' => 25000],
            ['nama' => 'Dosen', 'kode' => 'DSN', 'durasi_bulan' => 24, 'maks_pinjam' => 10, 'biaya' => 0],
            ['nama' => 'Umum', 'kode' => 'UMM', 'durasi_bulan' => 6, 'maks_pinjam' => 3, 'biaya' => 50000],
            ['nama' => 'Alumni', 'kode' => 'ALM', 'durasi_bulan' => 12, 'maks_pinjam' => 3, 'biaya' => 75000],
        ];

        foreach ($types as $type) {
            MembershipType::updateOrCreate(['kode' => $type['kode']], $type);
        }
    }
}
