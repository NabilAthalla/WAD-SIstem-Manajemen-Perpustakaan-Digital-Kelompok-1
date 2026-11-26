<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'membership_type_id',
        'tanggal_daftar',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'tanggal_daftar' => 'date',
            'tanggal_berlaku' => 'date',
        ];
    }

    protected static function booted(): void
    {
        // Masa berlaku dihitung otomatis dari tanggal daftar + durasi tipe keanggotaan.
        static::saving(function (Member $member) {
            $type = MembershipType::find($member->membership_type_id);

            if ($type && $member->tanggal_daftar) {
                $member->tanggal_berlaku = Carbon::parse($member->tanggal_daftar)
                    ->addMonths($type->durasi_bulan)
                    ->toDateString();
            }
        });

        // Nomor kartu dibuat otomatis saat anggota baru disimpan.
        static::creating(function (Member $member) {
            if (empty($member->nomor_kartu)) {
                $member->nomor_kartu = static::generateNomorKartu();
            }
        });
    }

    public static function generateNomorKartu(): string
    {
        $prefix = 'LIB' . date('y');
        $next = (int) static::max('id') + 1;

        do {
            $nomor = $prefix . str_pad((string) $next, 5, '0', STR_PAD_LEFT);
            $next++;
        } while (static::where('nomor_kartu', $nomor)->exists());

        return $nomor;
    }

    public function membershipType(): BelongsTo
    {
        return $this->belongsTo(MembershipType::class);
    }

    public function isExpired(): bool
    {
        return $this->tanggal_berlaku !== null
            && $this->tanggal_berlaku->copy()->endOfDay()->isPast();
    }

    public function scopeCari(Builder $query, array $filter): Builder
    {
        return $query
            ->when($filter['search'] ?? null, function (Builder $q, string $search) {
                $q->where(function (Builder $w) use ($search) {
                    $w->where('nama', 'like', "%{$search}%")
                        ->orWhere('nomor_kartu', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($filter['status'] ?? null, fn (Builder $q, string $status) => $q->where('status', $status))
            ->when(
                $filter['membership_type_id'] ?? null,
                fn (Builder $q, $id) => $q->where('membership_type_id', $id)
            );
    }
}
