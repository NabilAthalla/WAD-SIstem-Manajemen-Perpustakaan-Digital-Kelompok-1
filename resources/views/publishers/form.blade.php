@extends('layouts.app')

@php
    $isEdit = isset($publisher);
@endphp

@section('title', $isEdit ? 'Edit Penerbit' : 'Tambah Penerbit')
@section('heading', $isEdit ? 'Edit Penerbit' : 'Tambah Penerbit')

@section('content')
    <div class="page-head">
        <div>
            <a href="{{ route('publishers.index') }}" class="back-link">
                <i class="bi bi-arrow-left"></i> Kembali ke daftar
            </a>
            <span class="eyebrow">{{ $isEdit ? 'Perbarui Data' : 'Data Baru' }}</span>
            <h1>{{ $isEdit ? 'Edit Penerbit' : 'Tambah Penerbit' }}</h1>
            <p class="page-sub">
                {{ $isEdit
                    ? 'Perbarui informasi mitra penerbit agar data perpustakaan tetap akurat.'
                    : 'Lengkapi informasi di bawah untuk menambahkan mitra penerbit baru.' }}
            </p>
        </div>
    </div>

    <div class="form-card">
        <div class="form-card-head">
            <span class="head-icon"><i class="bi {{ $isEdit ? 'bi-pencil-square' : 'bi-building-add' }}"></i></span>
            <div>
                <h2>Informasi Penerbit</h2>
                <p>Kolom bertanda <span class="required">*</span> wajib diisi.</p>
            </div>
        </div>

        <form action="{{ $isEdit ? route('publishers.update', $publisher) : route('publishers.store') }}"
              method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="form-card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="nama_penerbit" class="form-label">
                            Nama Penerbit <span class="required">*</span>
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-buildings"></i>
                            <input type="text"
                                   id="nama_penerbit"
                                   name="nama_penerbit"
                                   class="form-control @error('nama_penerbit') is-invalid @enderror"
                                   value="{{ old('nama_penerbit', $publisher->nama_penerbit ?? '') }}"
                                   placeholder="Contoh: Gramedia Pustaka Utama"
                                   maxlength="100"
                                   required>
                        </div>
                        @error('nama_penerbit')
                            <span class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="kontak_sales" class="form-label">
                            Kontak Sales <span class="required">*</span>
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-telephone"></i>
                            <input type="text"
                                   id="kontak_sales"
                                   name="kontak_sales"
                                   class="form-control @error('kontak_sales') is-invalid @enderror"
                                   value="{{ old('kontak_sales', $publisher->kontak_sales ?? '') }}"
                                   placeholder="Contoh: 0812-3456-7890"
                                   maxlength="50"
                                   required>
                        </div>
                        @error('kontak_sales')
                            <span class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="alamat" class="form-label">
                            Alamat <span class="required">*</span>
                        </label>
                        <textarea id="alamat"
                                  name="alamat"
                                  rows="4"
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Tulis alamat lengkap penerbit..."
                                  required>{{ old('alamat', $publisher->alamat ?? '') }}</textarea>
                        @error('alamat')
                            <span class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="wilayah_asal" class="form-label">
                            Wilayah Asal <span class="required">*</span>
                        </label>
                        <div class="input-icon">
                            <i class="bi bi-geo-alt"></i>
                            <input type="text"
                                   id="wilayah_asal"
                                   name="wilayah_asal"
                                   class="form-control @error('wilayah_asal') is-invalid @enderror"
                                   value="{{ old('wilayah_asal', $publisher->wilayah_asal ?? '') }}"
                                   placeholder="Contoh: DKI Jakarta"
                                   maxlength="50"
                                   required>
                        </div>
                        @error('wilayah_asal')
                            <span class="field-error"><i class="bi bi-exclamation-circle"></i>{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-brand">
                        <i class="bi bi-check2-circle"></i>
                        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Data' }}
                    </button>
                    <a href="{{ route('publishers.index') }}" class="btn btn-ghost">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
