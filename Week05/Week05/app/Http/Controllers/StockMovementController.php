<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $movements = StockMovement::with(['product', 'user'])
            ->when(in_array($request->type, ['in', 'out']), function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->when($request->product_id, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $products = Product::orderBy('name')->get(['id', 'sku', 'name']);

        return view('stock.index', compact('movements', 'products'));
    }

    public function create(Request $request)
    {
        $products = Product::orderBy('name')->get();
        $selected = $request->query('product');

        return view('stock.create', compact('products', 'selected'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type'       => ['required', 'in:in,out'],
            'quantity'   => ['required', 'integer', 'min:1'],
            'note'       => ['nullable', 'max:255'],
        ], $this->pesan(), [
            'product_id' => 'Produk',
            'type'       => 'Jenis transaksi',
            'quantity'   => 'Jumlah',
            'note'       => 'Catatan',
        ]);

        DB::transaction(function () use ($validated) {
            // dikunci dulu supaya dua transaksi bareng nggak bikin stok salah hitung
            $product = Product::lockForUpdate()->findOrFail($validated['product_id']);

            $sebelum = $product->stock;

            if ($validated['type'] === 'out' && $validated['quantity'] > $sebelum) {
                throw ValidationException::withMessages([
                    'quantity' => "Stok tidak cukup. Stok tersedia hanya {$sebelum}.",
                ]);
            }

            $sesudah = $validated['type'] === 'in'
                ? $sebelum + $validated['quantity']
                : $sebelum - $validated['quantity'];

            $product->update(['stock' => $sesudah]);

            StockMovement::create([
                'product_id'   => $product->id,
                'user_id'      => auth()->id(),
                'type'         => $validated['type'],
                'quantity'     => $validated['quantity'],
                'stock_before' => $sebelum,
                'stock_after'  => $sesudah,
                'note'         => $validated['note'] ?? null,
            ]);
        });

        return redirect()->route('stock-movements.index')
            ->with('success', 'Transaksi stok berhasil dicatat.');
    }
}
