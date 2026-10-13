@extends('layouts.app')

@section('title', 'Catat Transaksi Stok')

@section('content')
<h1>Catat Transaksi Stok</h1>

<form method="POST" action="{{ route('stock-movements.store') }}" class="card form-card">
    @csrf

    <div class="form-group">
        <label for="product_id">Produk</label>
        <select id="product_id" name="product_id">
            <option value="">-- pilih produk --</option>
            @foreach ($products as $p)
                <option value="{{ $p->id }}" @selected(old('product_id', $selected) == $p->id)>
                    {{ $p->sku }} - {{ $p->name }} (stok: {{ $p->stock }})
                </option>
            @endforeach
        </select>
        @error('product_id') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-grid">
        <div class="form-group">
            <label for="type">Jenis Transaksi</label>
            <select id="type" name="type">
                <option value="in" @selected(old('type') === 'in')>Stok Masuk</option>
                <option value="out" @selected(old('type') === 'out')>Stok Keluar</option>
            </select>
            @error('type') <small class="error">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="quantity">Jumlah</label>
            <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}">
            @error('quantity') <small class="error">{{ $message }}</small> @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="note">Catatan <span class="muted">(opsional)</span></label>
        <input type="text" id="note" name="note" value="{{ old('note') }}">
        @error('note') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('stock-movements.index') }}" class="btn btn-light">Batal</a>
    </div>
</form>
@endsection
