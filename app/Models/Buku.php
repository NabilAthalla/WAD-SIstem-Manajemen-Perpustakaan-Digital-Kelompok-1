<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $fillable = [
        'judul', 'isbn', 'penulis', 'penerbit', 'tahun',
        'kategori_id', 'stok', 'cover', 'deskripsi', 'jumlah_halaman',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}