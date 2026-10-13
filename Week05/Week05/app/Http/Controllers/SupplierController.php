<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    private array $atribut = [
        'name'    => 'Nama supplier',
        'phone'   => 'No. telepon',
        'email'   => 'Email',
        'address' => 'Alamat',
    ];

    public function index()
    {
        $suppliers = Supplier::withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create', ['supplier' => new Supplier()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->pesan(), $this->atribut);

        Supplier::create($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate($this->rules(), $this->pesan(), $this->atribut);

        $supplier->update($validated);

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        // supplier_id di produk otomatis jadi null (lihat migration)
        $supplier->delete();

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }

    private function rules(): array
    {
        return [
            'name'    => ['required', 'max:120'],
            'phone'   => ['nullable', 'max:20'],
            'email'   => ['nullable', 'email', 'max:120'],
            'address' => ['nullable', 'max:255'],
        ];
    }
}
