@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<h1>Tambah Kategori</h1>

<form method="POST" action="{{ route('categories.store') }}" class="card form-card">
    @csrf
    @include('categories._form')

    <div class="form-actions">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('categories.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
