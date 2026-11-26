@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <div class="card">
        <h1>Edit Anggota: {{ $member->nomor_kartu }}</h1>
        <form method="POST" action="{{ route('members.update', $member) }}">
            @method('PUT')
            @include('members._form')
        </form>
    </div>
@endsection
