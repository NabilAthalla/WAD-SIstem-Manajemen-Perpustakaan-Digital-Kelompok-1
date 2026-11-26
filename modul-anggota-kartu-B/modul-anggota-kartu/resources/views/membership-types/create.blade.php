@extends('layouts.app')

@section('title', 'Tambah Tipe Keanggotaan')

@section('content')
    <div class="card">
        <h1>Tambah Tipe Keanggotaan</h1>
        <form method="POST" action="{{ route('membership-types.store') }}">
            @include('membership-types._form')
        </form>
    </div>
@endsection
