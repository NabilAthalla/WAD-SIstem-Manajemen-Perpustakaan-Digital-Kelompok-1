@extends('layouts.app')

@section('title', 'Edit Buku - LiteraHub')

@section('content')
<div class="page-header">
    <div class="crumb">Modul A · Katalog & Buku</div>
    <h2>Edit Buku</h2>
</div>

<div class="card card-custom p-4">
    <form action="{{ route('buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('buku._form')

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-gold px-4">Perbarui</button>
            <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection