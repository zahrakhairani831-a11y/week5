<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private array $atribut = [
        'category_id'   => 'Kategori',
        'supplier_id'   => 'Supplier',
        'sku'           => 'SKU',
        'name'          => 'Nama produk',
        'description'   => 'Deskripsi',
        'price'         => 'Harga',
        'stock'         => 'Stok awal',
        'minimum_stock' => 'Stok minimum',
    ];

    public function index(Request $request)
    {
        // kolom yang boleh dipakai buat sorting, selain ini dianggap name
        $kolomBoleh = ['name', 'sku', 'price', 'stock'];
        $sort = in_array($request->sort, $kolomBoleh) ? $request->sort : 'name';
        $dir  = $request->dir === 'desc' ? 'desc' : 'asc';

        $products = Product::with('category')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($request->status === 'habis', function ($query) {
                $query->where('stock', 0);
            })
            ->when($request->status === 'menipis', function ($query) {
                $query->where('stock', '>', 0)->whereColumn('stock', '<=', 'minimum_stock');
            })
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories', 'sort', 'dir'));
    }

    public function create()
    {
        return view('products.create', [
            'product'    => new Product(),
            'categories' => Category::orderBy('name')->get(),
            'suppliers'  => Supplier::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->pesan(), $this->atribut);

        DB::transaction(function () use ($validated) {
            $product = Product::create($validated);

            // stok awal dicatat sebagai transaksi masuk biar riwayatnya lengkap
            if ($product->stock > 0) {
                StockMovement::create([
                    'product_id'   => $product->id,
                    'user_id'      => auth()->id(),
                    'type'         => 'in',
                    'quantity'     => $product->stock,
                    'stock_before' => 0,
                    'stock_after'  => $product->stock,
                    'note'         => 'Stok awal produk',
                ]);
            }
        });

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil disimpan.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'supplier']);
        $riwayat = $product->stockMovements()->latest()->take(10)->get();

        return view('products.show', compact('product', 'riwayat'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product'    => $product,
            'categories' => Category::orderBy('name')->get(),
            'suppliers'  => Supplier::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate($this->rules($product), $this->pesan(), $this->atribut);

        // stok sengaja nggak ikut diupdate, perubahan stok harus lewat transaksi stok
        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function rules(?Product $product = null): array
    {
        $rules = [
            'category_id'   => ['required', 'exists:categories,id'],
            'supplier_id'   => ['nullable', 'exists:suppliers,id'],
            'sku'           => ['required', 'max:30', Rule::unique('products', 'sku')->ignore($product?->id)],
            'name'          => ['required', 'max:150'],
            'description'   => ['nullable', 'max:500'],
            'price'         => ['required', 'numeric', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
        ];

        // stok awal cuma diisi waktu produk baru dibuat
        if (! $product) {
            $rules['stock'] = ['required', 'integer', 'min:0'];
        }

        return $rules;
    }
}
