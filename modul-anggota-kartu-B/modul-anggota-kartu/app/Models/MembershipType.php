<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipType extends Model
{
    protected $fillable = ['nama', 'kode', 'durasi_bulan', 'maks_pinjam', 'biaya'];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
