@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
    <div class="card">
        <div class="toolbar">
            <h1 style="margin: 0;">Detail Anggota</h1>
            <div>
                <a href="{{ route('members.card', $member) }}" class="btn btn-amber" target="_blank">Cetak ID Card</a>
                <a href="{{ route('members.edit', $member) }}" class="btn">Edit</a>
                <a href="{{ route('members.index') }}" class="btn btn-gray">Kembali</a>
            </div>
        </div>

        <dl>
            <dt>Nomor Kartu</dt><dd>{{ $member->nomor_kartu }}</dd>
            <dt>Nama</dt><dd>{{ $member->nama }}</dd>
            <dt>Email</dt><dd>{{ $member->email }}</dd>
            <dt>Nomor Telepon</dt><dd>{{ $member->no_telepon ?: '-' }}</dd>
            <dt>Alamat</dt><dd>{{ $member->alamat ?: '-' }}</dd>
            <dt>Tanggal Lahir</dt><dd>{{ $member->tanggal_lahir?->format('d/m/Y') ?? '-' }}</dd>
            <dt>Jenis Kelamin</dt><dd>{{ $member->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
            <dt>Tipe Keanggotaan</dt><dd>{{ $member->membershipType->nama ?? '-' }}</dd>
            <dt>Maks. Pinjam</dt><dd>{{ $member->membershipType->maks_pinjam ?? '-' }} buku</dd>
            <dt>Tanggal Daftar</dt><dd>{{ $member->tanggal_daftar?->format('d/m/Y') }}</dd>
            <dt>Berlaku s.d.</dt>
            <dd>
                {{ $member->tanggal_berlaku?->format('d/m/Y') }}
                @if ($member->isExpired())
                    <span class="badge badge-expired">Kedaluwarsa</span>
                @endif
            </dd>
            <dt>Status</dt><dd><span class="badge badge-{{ $member->status }}">{{ ucfirst($member->status) }}</span></dd>
        </dl>
    </div>
@endsection
