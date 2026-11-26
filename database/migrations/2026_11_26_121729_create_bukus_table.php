<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('bukus', function (Blueprint $table) {
    $table->id();
    $table->string('judul');
    $table->string('isbn', 20)->unique();
    $table->string('penulis');
    $table->string('penerbit');
    $table->unsignedSmallInteger('tahun');
    $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->nullOnDelete();
    $table->unsignedInteger('stok')->default(0);
    $table->string('cover')->nullable();
    $table->text('deskripsi')->nullable();
    $table->unsignedInteger('jumlah_halaman')->nullable();
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};