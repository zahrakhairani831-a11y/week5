@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div class="page-head">
    <h1>Supplier</h1>
    <a href="{{ route('suppliers.create') }}" class="btn">+ Tambah Supplier</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr><th>Nama</th><th>Telepon</th><th>Email</th><th class="num">Produk</th><th class="aksi">Aksi</th></tr>
        </thead>
        <tbody>
            @forelse ($suppliers as $supplier)
                <tr>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->phone ?: '-' }}</td>
                    <td>{{ $supplier->email ?: '-' }}</td>
                    <td class="num">{{ $supplier->products_count }}</td>
                    <td class="aksi">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-small btn-light">Edit</a>
                        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}" class="inline"
                              onsubmit="return confirm('Hapus supplier ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-small btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">Belum ada supplier.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $suppliers->links() }}
@endsection
