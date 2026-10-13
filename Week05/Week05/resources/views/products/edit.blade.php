@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<h1>Edit Produk</h1>

<form method="POST" action="{{ route('products.update', $product) }}" class="card form-card">
    @csrf
    @method('PUT')
    @include('products._form')

    <div class="form-actions">
        <button type="submit" class="btn">Perbarui</button>
        <a href="{{ route('products.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
