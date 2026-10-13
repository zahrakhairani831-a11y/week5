@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<h1>Edit Kategori</h1>

<form method="POST" action="{{ route('categories.update', $category) }}" class="card form-card">
    @csrf
    @method('PUT')
    @include('categories._form')

    <div class="form-actions">
        <button type="submit" class="btn">Perbarui</button>
        <a href="{{ route('categories.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
