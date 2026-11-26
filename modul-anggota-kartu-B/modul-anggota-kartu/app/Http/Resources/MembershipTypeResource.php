<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipTypeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'kode' => $this->kode,
            'durasi_bulan' => $this->durasi_bulan,
            'maks_pinjam' => $this->maks_pinjam,
            'biaya' => $this->biaya,
        ];
    }
}
