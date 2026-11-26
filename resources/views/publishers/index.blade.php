@extends('layouts.app')

@section('title', 'Data Penerbit & Supplier')
@section('heading', 'Data Penerbit')

@section('content')
    @php
        $totalPenerbit = $publishers->count();
        $totalWilayah = $publishers->pluck('wilayah_asal')->unique()->count();
        $latestUpdate = $publishers->max('updated_at');
    @endphp

    <div class="page-head">
        <div>
            <span class="eyebrow">Perpustakaan Digital</span>
            <h1>Data Penerbit &amp; Supplier</h1>
            <p class="page-sub">Kelola seluruh mitra penerbit dan supplier perpustakaan Anda dalam satu tempat.</p>
        </div>
        <a href="{{ route('publishers.create') }}" class="btn btn-brand">
            <i class="bi bi-plus-lg"></i> Tambah Penerbit
        </a>
    </div>

    <div class="row g-3 stats-row">
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <span class="stat-icon tint-indigo"><i class="bi bi-buildings"></i></span>
                <div>
                    <span class="stat-label">Total Penerbit</span>
                    <strong class="stat-value">{{ $totalPenerbit }}</strong>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <span class="stat-icon tint-cyan"><i class="bi bi-geo-alt"></i></span>
                <div>
                    <span class="stat-label">Wilayah Asal</span>
                    <strong class="stat-value">{{ $totalWilayah }}</strong>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="stat-card">
                <span class="stat-icon tint-amber"><i class="bi bi-clock-history"></i></span>
                <div>
                    <span class="stat-label">Pembaruan Terakhir</span>
                    <strong class="stat-value is-date">
                        {{ $latestUpdate ? $latestUpdate->format('d M Y') : 'Belum ada data' }}
                    </strong>
                </div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="search"
                       id="publisherSearch"
                       placeholder="Cari penerbit, wilayah, atau kontak..."
                       autocomplete="off"
                       aria-label="Cari penerbit">
            </div>
            <span class="result-count">
                <strong id="resultCount">{{ $totalPenerbit }}</strong> penerbit ditemukan
            </span>
        </div>

        @if ($publishers->isEmpty())
            <div class="empty-state">
                <span class="empty-icon"><i class="bi bi-journal-bookmark"></i></span>
                <h3>Belum ada penerbit</h3>
                <p>Tambahkan data penerbit pertama untuk mulai membangun daftar mitra Anda.</p>
                <a href="{{ route('publishers.create') }}" class="btn btn-brand">
                    <i class="bi bi-plus-lg"></i> Tambah Penerbit
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Penerbit</th>
                            <th scope="col">Kontak Sales</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Wilayah Asal</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($publishers as $publisher)
                            @php
                                $initials = collect(explode(' ', $publisher->nama_penerbit))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn ($word) => mb_substr($word, 0, 1))
                                    ->implode('');
                                $searchText = mb_strtolower(
                                    $publisher->nama_penerbit . ' ' .
                                    $publisher->kontak_sales . ' ' .
                                    $publisher->alamat . ' ' .
                                    $publisher->wilayah_asal
                                );
                            @endphp
                            <tr data-publisher-row data-search="{{ $searchText }}">
                                <td class="text-muted">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="publisher-cell">
                                        <span class="publisher-avatar">{{ $initials }}</span>
                                        <div>
                                            <span class="publisher-name">{{ $publisher->nama_penerbit }}</span>
                                            <span class="publisher-id">ID #{{ str_pad($publisher->id, 3, '0', STR_PAD_LEFT) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="contact">
                                        <i class="bi bi-telephone"></i> {{ $publisher->kontak_sales }}
                                    </span>
                                </td>
                                <td>
                                    <span class="address" title="{{ $publisher->alamat }}">{{ $publisher->alamat }}</span>
                                </td>
                                <td>
                                    <span class="pill"><span class="dot"></span>{{ $publisher->wilayah_asal }}</span>
                                </td>
                                <td>
                                    <div class="row-actions justify-content-end">
                                        <a href="{{ route('publishers.edit', $publisher) }}"
                                           class="icon-btn edit"
                                           title="Edit {{ $publisher->nama_penerbit }}"
                                           aria-label="Edit {{ $publisher->nama_penerbit }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('publishers.destroy', $publisher) }}"
                                              method="POST"
                                              class="m-0"
                                              onsubmit="return confirm('Yakin ingin menghapus data penerbit ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="icon-btn delete"
                                                    title="Hapus {{ $publisher->nama_penerbit }}"
                                                    aria-label="Hapus {{ $publisher->nama_penerbit }}">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="no-results" id="searchEmpty" hidden>
                <i class="bi bi-search"></i>
                <h3>Tidak ada hasil</h3>
                <p>Coba gunakan kata kunci lain untuk menemukan penerbit.</p>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const input = document.getElementById('publisherSearch');
            if (!input) return;

            const rows = Array.from(document.querySelectorAll('[data-publisher-row]'));
            const empty = document.getElementById('searchEmpty');
            const count = document.getElementById('resultCount');

            input.addEventListener('input', function () {
                const query = input.value.trim().toLowerCase();
                let visible = 0;

                rows.forEach(function (row) {
                    const match = !query || row.dataset.search.includes(query);
                    row.hidden = !match;
                    if (match) visible++;
                });

                if (empty) empty.hidden = visible !== 0;
                if (count) count.textContent = visible;
            });
        })();
    </script>
@endpush
