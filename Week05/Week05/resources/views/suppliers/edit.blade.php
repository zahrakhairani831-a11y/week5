@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<h1>Edit Supplier</h1>

<form method="POST" action="{{ route('suppliers.update', $supplier) }}" class="card form-card">
    @csrf
    @method('PUT')
    @include('suppliers._form')

    <div class="form-actions">
        <button type="submit" class="btn">Perbarui</button>
        <a href="{{ route('suppliers.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
