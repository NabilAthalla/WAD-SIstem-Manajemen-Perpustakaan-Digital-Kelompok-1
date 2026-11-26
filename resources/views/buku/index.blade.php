@extends('layouts.app')

@section('title', 'Katalog & Buku - LiteraHub')

@section('content')
<div class="d-flex justify-content-between align-items-end flex-wrap gap-3 page-header">
    <div>
        <div class="crumb">Modul A · Katalog & Buku</div>
        <h2>Daftar Katalog Buku</h2>
        <p>Kelola master data buku, ISBN, penerbit, dan stok literatur digital.</p>
    </div>

    @if (auth()->user()->isAdmin())
        <a href="{{ route('buku.create') }}" class="btn btn-gold px-4 py-2">
            <i class="bi bi-plus-lg me-1"></i> Tambah Buku Baru
        </a>
    @endif
</div>

<div class="card card-custom p-3">
    <form method="GET" action="{{ route('buku.index') }}" class="d-flex justify-content-end mb-3">
        <div class="input-group" style="max-width: 320px;">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari judul / penulis...">
            <button class="btn btn-gold"><i class="bi bi-search"></i></button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-head">
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul Buku</th>
                    <th>ISBN</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bukus as $buku)
                    <tr>
                        <td>{{ $bukus->firstItem() + $loop->index }}</td>
                        <td>
                            @if ($buku->cover)
                                <img src="{{ asset('storage/' . $buku->cover) }}" alt="cover" width="48" height="64" class="rounded object-fit-cover">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:48px;height:64px;">
                                    <i class="bi bi-book text-secondary"></i>
                                </div>
                            @endif
                        </td>
                        <td><a href="{{ route('buku.show', $buku) }}" class="fw-bold text-decoration-none">{{ $buku->judul }}</a></td>
                        <td><span class="badge bg-light text-dark border">{{ $buku->isbn }}</span></td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ $buku->penerbit }}</td>
                        <td>{{ $buku->tahun }}</td>
                        <td><span class="badge bg-primary-subtle text-primary">{{ $buku->kategori->nama ?? '-' }}</span></td>
                        <td>
                            <strong>{{ $buku->stok }}</strong> pcs
                            @if ($buku->stok > 0)
                                <span class="badge bg-success-subtle text-success">Tersedia</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">Habis</span>
                            @endif
                        </td>
                        <td class="text-center text-nowrap">
                            <a href="{{ route('buku.show', $buku) }}" class="btn btn-sm btn-outline-primary" title="Lihat">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if (auth()->user()->isAdmin())
                                <a href="{{ route('buku.edit', $buku) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('buku.destroy', $buku) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center text-muted py-4">Belum ada data buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-2">{{ $bukus->links() }}</div>
</div>
@endsection