@extends('layouts.app')

@section('title', 'Tambah Supplier')

@section('content')
<h1>Tambah Supplier</h1>

<form method="POST" action="{{ route('suppliers.store') }}" class="card form-card">
    @csrf
    @include('suppliers._form')

    <div class="form-actions">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
