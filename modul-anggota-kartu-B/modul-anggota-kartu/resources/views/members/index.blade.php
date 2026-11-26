@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
    <div class="card">
        <div class="toolbar">
            <h1 style="margin: 0;">Daftar Anggota</h1>
            <a href="{{ route('members.create') }}" class="btn">+ Tambah Anggota</a>
        </div>

        <form method="GET" action="{{ route('members.index') }}" class="filters">
            <div>
                <label for="search">Cari</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Nama, nomor kartu, atau email">
            </div>
            <div>
                <label for="status">Status</label>
                <select id="status" name="status">
                    <option value="">Semua</option>
                    <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                    <option value="nonaktif" @selected(request('status') === 'nonaktif')>Nonaktif</option>
                </select>
            </div>
            <div>
                <label for="membership_type_id">Tipe</label>
                <select id="membership_type_id" name="membership_type_id">
                    <option value="">Semua</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" @selected((string) request('membership_type_id') === (string) $type->id)>{{ $type->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-blue">Filter</button>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Kartu</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Berlaku s.d.</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr>
                        <td>{{ $members->firstItem() + $loop->index }}</td>
                        <td>{{ $member->nomor_kartu }}</td>
                        <td>{{ $member->nama }}<br><span class="muted">{{ $member->email }}</span></td>
                        <td>{{ $member->membershipType->nama ?? '-' }}</td>
                        <td>
                            {{ $member->tanggal_berlaku?->format('d/m/Y') }}
                            @if ($member->isExpired())
                                <span class="badge badge-expired">Kedaluwarsa</span>
                            @endif
                        </td>
                        <td><span class="badge badge-{{ $member->status }}">{{ ucfirst($member->status) }}</span></td>
                        <td>
                            <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-blue">Detail</a>
                            <a href="{{ route('members.card', $member) }}" class="btn btn-sm btn-amber" target="_blank">Kartu</a>
                            <a href="{{ route('members.edit', $member) }}" class="btn btn-sm">Edit</a>
                            <form method="POST" action="{{ route('members.destroy', $member) }}" class="inline" onsubmit="return confirm('Hapus anggota ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-red">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;" class="muted">Belum ada data anggota.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $members->links('pagination::default') }}
    </div>
@endsection
