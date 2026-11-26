@extends('layouts.app')

@section('title', 'Tipe Keanggotaan')

@section('content')
    <div class="card">
        <div class="toolbar">
            <h1 style="margin: 0;">Tipe Keanggotaan</h1>
            <a href="{{ route('membership-types.create') }}" class="btn">+ Tambah Tipe</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Durasi</th>
                    <th>Maks. Pinjam</th>
                    <th>Biaya</th>
                    <th>Anggota</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($types as $type)
                    <tr>
                        <td>{{ $type->kode }}</td>
                        <td>{{ $type->nama }}</td>
                        <td>{{ $type->durasi_bulan }} bulan</td>
                        <td>{{ $type->maks_pinjam }} buku</td>
                        <td>Rp {{ number_format($type->biaya, 0, ',', '.') }}</td>
                        <td>{{ $type->members_count }}</td>
                        <td>
                            <a href="{{ route('membership-types.edit', $type) }}" class="btn btn-sm">Edit</a>
                            <form method="POST" action="{{ route('membership-types.destroy', $type) }}" class="inline" onsubmit="return confirm('Hapus tipe ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-red">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;" class="muted">Belum ada tipe keanggotaan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
