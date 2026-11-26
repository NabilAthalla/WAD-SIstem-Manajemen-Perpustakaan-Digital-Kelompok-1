<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\MembershipType;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['nama' => 'Budi Santoso', 'email' => 'budi@example.com', 'no_telepon' => '081234567801', 'alamat' => 'Jl. Telekomunikasi No. 1, Bandung', 'tanggal_lahir' => '2003-04-12', 'jenis_kelamin' => 'L', 'kode' => 'MHS', 'tanggal_daftar' => '2026-09-01', 'status' => 'aktif'],
            ['nama' => 'Siti Aminah', 'email' => 'siti@example.com', 'no_telepon' => '081234567802', 'alamat' => 'Jl. Buah Batu No. 10, Bandung', 'tanggal_lahir' => '2002-11-30', 'jenis_kelamin' => 'P', 'kode' => 'MHS', 'tanggal_daftar' => '2026-09-05', 'status' => 'aktif'],
            ['nama' => 'Dr. Andi Wijaya', 'email' => 'andi@example.com', 'no_telepon' => '081234567803', 'alamat' => 'Jl. Dipatiukur No. 22, Bandung', 'tanggal_lahir' => '1985-02-20', 'jenis_kelamin' => 'L', 'kode' => 'DSN', 'tanggal_daftar' => '2026-01-15', 'status' => 'aktif'],
            ['nama' => 'Rina Marlina', 'email' => 'rina@example.com', 'no_telepon' => '081234567804', 'alamat' => 'Jl. Cihampelas No. 5, Bandung', 'tanggal_lahir' => '1995-07-08', 'jenis_kelamin' => 'P', 'kode' => 'UMM', 'tanggal_daftar' => '2025-01-10', 'status' => 'nonaktif'],
            ['nama' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'no_telepon' => '081234567805', 'alamat' => 'Jl. Soekarno Hatta No. 77, Bandung', 'tanggal_lahir' => '1998-09-17', 'jenis_kelamin' => 'P', 'kode' => 'ALM', 'tanggal_daftar' => '2026-06-01', 'status' => 'aktif'],
        ];

        foreach ($members as $row) {
            $typeId = MembershipType::where('kode', $row['kode'])->value('id');
            unset($row['kode']);

            if (Member::where('email', $row['email'])->exists()) {
                continue;
            }

            Member::create($row + ['membership_type_id' => $typeId]);
        }
    }
}
