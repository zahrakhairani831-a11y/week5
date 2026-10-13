@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="page-head">
    <h1>{{ $product->name }}</h1>
    <div>
        <a href="{{ route('stock-movements.create', ['product' => $product->id]) }}" class="btn">Catat Stok</a>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-light">Edit</a>
    </div>
</div>

<div class="card">
    <dl class="detail">
        <dt>SKU</dt><dd>{{ $product->sku }}</dd>
        <dt>Kategori</dt><dd>{{ $product->category->name }}</dd>
        <dt>Supplier</dt><dd>{{ $product->supplier->name ?? '-' }}</dd>
        <dt>Harga</dt><dd>Rp {{ number_format($product->price, 0, ',', '.') }}</dd>
        <dt>Stok</dt>
        <dd>
            {{ $product->stock }} (minimum {{ $product->minimum_stock }})
            <span class="badge badge-{{ strtolower($product->statusStok()) }}">{{ $product->statusStok() }}</span>
        </dd>
        <dt>Deskripsi</dt><dd>{{ $product->description ?: '-' }}</dd>
    </dl>
</div>

<div class="card">
    <h2>Riwayat Stok (10 terakhir)</h2>
    <table>
        <thead>
            <tr><th>Waktu</th><th>Jenis</th><th class="num">Jumlah</th><th class="num">Sebelum</th><th class="num">Sesudah</th><th>Catatan</th></tr>
        </thead>
        <tbody>
            @forelse ($riwayat as $r)
                <tr>
                    <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                    <td><span class="badge badge-{{ $r->type }}">{{ $r->type === 'in' ? 'Masuk' : 'Keluar' }}</span></td>
                    <td class="num">{{ $r->quantity }}</td>
                    <td class="num">{{ $r->stock_before }}</td>
                    <td class="num">{{ $r->stock_after }}</td>
                    <td>{{ $r->note ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">Belum ada riwayat.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<a href="{{ route('products.index') }}" class="btn btn-light">&laquo; Kembali</a>
@endsection
