<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MembershipTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $type = $this->route('membership_type');

        return [
            'nama' => ['required', 'string', 'max:50', Rule::unique('membership_types', 'nama')->ignore($type)],
            'kode' => ['required', 'alpha_dash', 'max:10', Rule::unique('membership_types', 'kode')->ignore($type)],
            'durasi_bulan' => ['required', 'integer', 'min:1', 'max:120'],
            'maks_pinjam' => ['required', 'integer', 'min:1', 'max:50'],
            'biaya' => ['required', 'integer', 'min:0'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama tipe',
            'kode' => 'kode',
            'durasi_bulan' => 'durasi (bulan)',
            'maks_pinjam' => 'maksimal pinjam',
            'biaya' => 'biaya',
        ];
    }
}
