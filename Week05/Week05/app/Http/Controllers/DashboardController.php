<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk     = Product::count();
        $totalKategori   = Category::count();
        $totalSupplier   = Supplier::count();
        $nilaiPersediaan = Product::selectRaw('COALESCE(SUM(price * stock), 0) as total')->value('total');

        $stokMenipis = Product::with('category')
            ->whereColumn('stock', '<=', 'minimum_stock')
            ->orderBy('stock')
            ->take(8)
            ->get();

        $transaksiTerakhir = StockMovement::with('product')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalProduk', 'totalKategori', 'totalSupplier',
            'nilaiPersediaan', 'stokMenipis', 'transaksiTerakhir'
        ));
    }
}
