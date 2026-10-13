@extends('layouts.app')

@section('title', 'Transaksi Stok')

@section('content')
<div class="page-head">
    <h1>Transaksi Stok</h1>
    <a href="{{ route('stock-movements.create') }}" class="btn">+ Catat Transaksi</a>
</div>

<form method="GET" action="{{ route('stock-movements.index') }}" class="filter">
    <select name="product_id">
        <option value="">Semua produk</option>
        @foreach ($products as $p)
            <option value="{{ $p->id }}" @selected(request('product_id') == $p->id)>{{ $p->sku }} - {{ $p->name }}</option>
        @endforeach
    </select>

    <select name="type">
        <option value="">Masuk &amp; keluar</option>
        <option value="in" @selected(request('type') === 'in')>Masuk</option>
        <option value="out" @selected(request('type') === 'out')>Keluar</option>
    </select>

    <button type="submit" class="btn">Filter</button>
    <a href="{{ route('stock-movements.index') }}" class="btn btn-light">Reset</a>
</form>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Waktu</th><th>Produk</th><th>Jenis</th>
                <th class="num">Jumlah</th><th class="num">Sebelum</th><th class="num">Sesudah</th>
                <th>Oleh</th><th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movements as $m)
                <tr>
                    <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $m->product->name }}</td>
                    <td><span class="badge badge-{{ $m->type }}">{{ $m->type === 'in' ? 'Masuk' : 'Keluar' }}</span></td>
                    <td class="num">{{ $m->quantity }}</td>
                    <td class="num">{{ $m->stock_before }}</td>
                    <td class="num">{{ $m->stock_after }}</td>
                    <td>{{ $m->user->name ?? '-' }}</td>
                    <td>{{ $m->note ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="8" class="empty">Belum ada transaksi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $movements->links() }}
@endsection
