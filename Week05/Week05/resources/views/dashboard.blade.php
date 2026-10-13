@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1>Dashboard</h1>

<div class="stats">
    <div class="stat">
        <span>Total Produk</span>
        <strong>{{ $totalProduk }}</strong>
    </div>
    <div class="stat">
        <span>Kategori</span>
        <strong>{{ $totalKategori }}</strong>
    </div>
    <div class="stat">
        <span>Supplier</span>
        <strong>{{ $totalSupplier }}</strong>
    </div>
    <div class="stat">
        <span>Nilai Persediaan</span>
        <strong>Rp {{ number_format($nilaiPersediaan, 0, ',', '.') }}</strong>
    </div>
</div>

<div class="two-col">
    <section class="card">
        <h2>Stok Menipis / Habis</h2>
        <table>
            <thead>
                <tr><th>Produk</th><th>Kategori</th><th class="num">Stok</th><th>Status</th></tr>
            </thead>
            <tbody>
                @forelse ($stokMenipis as $p)
                    <tr>
                        <td><a href="{{ route('products.show', $p) }}">{{ $p->name }}</a></td>
                        <td>{{ $p->category->name }}</td>
                        <td class="num">{{ $p->stock }}</td>
                        <td><span class="badge badge-{{ strtolower($p->statusStok()) }}">{{ $p->statusStok() }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">Semua stok masih aman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <section class="card">
        <h2>Transaksi Terakhir</h2>
        <table>
            <thead>
                <tr><th>Produk</th><th>Jenis</th><th class="num">Jumlah</th><th>Waktu</th></tr>
            </thead>
            <tbody>
                @forelse ($transaksiTerakhir as $t)
                    <tr>
                        <td>{{ $t->product->name }}</td>
                        <td><span class="badge badge-{{ $t->type }}">{{ $t->type === 'in' ? 'Masuk' : 'Keluar' }}</span></td>
                        <td class="num">{{ $t->quantity }}</td>
                        <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>
@endsection
