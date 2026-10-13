@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<h1>Tambah Produk</h1>

<form method="POST" action="{{ route('products.store') }}" class="card form-card">
    @csrf
    @include('products._form')

    <div class="form-actions">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('products.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
