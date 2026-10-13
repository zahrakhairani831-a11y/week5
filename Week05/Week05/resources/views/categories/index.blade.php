@extends('layouts.app')

@section('title', 'Kategori')

@section('content')
<div class="page-head">
    <h1>Kategori</h1>
    <a href="{{ route('categories.create') }}" class="btn">+ Tambah Kategori</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr><th>Nama</th><th>Deskripsi</th><th class="num">Jumlah Produk</th><th class="aksi">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description ?: '-' }}</td>
                    <td class="num">{{ $category->products_count }}</td>
                    <td class="aksi">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-small btn-light">Edit</a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" class="inline"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-small btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $categories->links() }}
@endsection
