<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nomor_kartu' => $this->nomor_kartu,
            'nama' => $this->nama,
            'email' => $this->email,
            'no_telepon' => $this->no_telepon,
            'alamat' => $this->alamat,
            'tanggal_lahir' => $this->tanggal_lahir?->toDateString(),
            'jenis_kelamin' => $this->jenis_kelamin,
            'tanggal_daftar' => $this->tanggal_daftar?->toDateString(),
            'tanggal_berlaku' => $this->tanggal_berlaku?->toDateString(),
            'status' => $this->status,
            'kedaluwarsa' => $this->isExpired(),
            'tipe_keanggotaan' => new MembershipTypeResource($this->whenLoaded('membershipType')),
        ];
    }
}
