<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_kartu', 20)->unique();
            $table->string('nama', 100);
            $table->string('email', 150)->unique();
            $table->string('no_telepon', 20)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin', 1);
            $table->foreignId('membership_type_id')
                ->constrained('membership_types')
                ->restrictOnDelete();
            $table->date('tanggal_daftar');
            $table->date('tanggal_berlaku');
            $table->string('status', 10)->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
