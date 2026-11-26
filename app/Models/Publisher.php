<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    // Kolom yang boleh diisi lewat create() / update()
    protected $fillable = [
        'nama_penerbit',
        'kontak_sales',
        'alamat',
        'wilayah_asal',
    ];
}
