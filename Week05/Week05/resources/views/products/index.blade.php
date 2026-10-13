@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="page-head">
    <h1>Daftar Produk</h1>
    <a href="{{ route('products.create') }}" class="btn">+ Tambah Produk</a>
</div>

<form method="GET" action="{{ route('products.index') }}" class="filter">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU...">

    <select name="category_id">
        <option value="">Semua kategori</option>
        @foreach ($categories as $c)
            <option value="{{ $c->id }}" @selected(request('category_id') == $c->id)>{{ $c->name }}</option>
        @endforeach
    </select>

    <select name="status">
        <option value="">Semua status stok</option>
        <option value="menipis" @selected(request('status') === 'menipis')>Menipis</option>
        <option value="habis" @selected(request('status') === 'habis')>Habis</option>
    </select>

    <button type="submit" class="btn">Cari</button>
    <a href="{{ route('products.index') }}" class="btn btn-light">Reset</a>
</form>

<div class="card">
    <table>
        <thead>
            <tr>
                <th><x-sort-link column="sku" label="SKU" /></th>
                <th><x-sort-link column="name" label="Nama Produk" /></th>
                <th>Kategori</th>
                <th class="num"><x-sort-link column="price" label="Harga" /></th>
                <th class="num"><x-sort-link column="stock" label="Stok" /></th>
                <th>Status</th>
                <th class="aksi">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->sku }}</td>
                    <td><a href="{{ route('products.show', $product) }}">{{ $product->name }}</a></td>
                    <td>{{ $product->category->name }}</td>
                    <td class="num">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="num">{{ $product->stock }}</td>
                    <td><span class="badge badge-{{ strtolower($product->statusStok()) }}">{{ $product->statusStok() }}</span></td>
                    <td class="aksi">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-small btn-light">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline"
                              onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-small btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="empty">Belum ada produk.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $products->links() }}
@endsection
