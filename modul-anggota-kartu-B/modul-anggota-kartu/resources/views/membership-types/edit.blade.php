@extends('layouts.app')

@section('title', 'Edit Tipe Keanggotaan')

@section('content')
    <div class="card">
        <h1>Edit Tipe Keanggotaan</h1>
        <form method="POST" action="{{ route('membership-types.update', $type) }}">
            @method('PUT')
            @include('membership-types._form')
        </form>
    </div>
@endsection
