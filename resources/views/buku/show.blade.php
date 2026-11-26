@extends('layouts.app')

@section('title', $buku->judul . ' - LiteraHub')

@section('content')
<a href="{{ route('buku.index') }}" class="text-decoration-none"><i class="bi bi-arrow-left"></i> Kembali</a>

<div class="card card-custom p-4 mt-3">
    <div class="row g-4">
        <div class="col-md-3 text-center">
            @if ($buku->cover)
                <img src="{{ asset('storage/' . $buku->cover) }}" class="img-fluid rounded" alt="cover">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:260px;">
                    <i class="bi bi-book fs-1 text-secondary"></i>
                </div>
            @endif
        </div>
        <div class="col-md-9">
            <h3 class="brand fw-bold">{{ $buku->judul }}</h3>
            <table class="table table-borderless mt-3 mb-0">
                <tr><th style="width:160px">ISBN</th><td>{{ $buku->isbn }}</td></tr>
                <tr><th>Penulis</th><td>{{ $buku->penulis }}</td></tr>
                <tr><th>Penerbit</th><td>{{ $buku->penerbit }}</td></tr>
                <tr><th>Tahun Terbit</th><td>{{ $buku->tahun }}</td></tr>
                <tr><th>Kategori</th><td>{{ $buku->kategori->nama ?? '-' }}</td></tr>
                <tr><th>Stok</th><td>{{ $buku->stok }} pcs</td></tr>
            </table>

            @if (auth()->user()->isAdmin())
                <a href="{{ route('buku.edit', $buku) }}" class="btn btn-gold mt-3">
                    <i class="bi bi-pencil-square me-1"></i> Edit Buku
                </a>
            @endif
        </div>
    </div>
</div>
@endsection