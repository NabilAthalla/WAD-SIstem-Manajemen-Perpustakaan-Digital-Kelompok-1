<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BukuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'judul'     => $this->judul,
            'isbn'      => $this->isbn,
            'penulis'   => $this->penulis,
            'penerbit'  => $this->penerbit,
            'tahun'     => $this->tahun,
            'kategori'  => $this->kategori?->nama,
            'stok'      => $this->stok,
            'cover_url' => $this->cover ? asset('storage/' . $this->cover) : null,
        ];
    }
}