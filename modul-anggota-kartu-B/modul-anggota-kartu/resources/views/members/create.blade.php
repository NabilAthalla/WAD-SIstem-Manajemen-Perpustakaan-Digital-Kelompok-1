@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
    <div class="card">
        <h1>Tambah Anggota</h1>
        <form method="POST" action="{{ route('members.store') }}">
            @include('members._form')
        </form>
    </div>
@endsection
