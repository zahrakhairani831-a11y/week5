<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules(), $this->pesan(), $this->atribut());

        Category::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate($this->rules($category), $this->pesan(), $this->atribut());

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // kategori yang masih punya produk nggak boleh dihapus
        if ($category->products()->exists()) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih dipakai oleh produk.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    private function rules(?Category $category = null): array
    {
        return [
            'name'        => ['required', 'max:100', Rule::unique('categories', 'name')->ignore($category?->id)],
            'description' => ['nullable', 'max:255'],
        ];
    }

    private function atribut(): array
    {
        return ['name' => 'Nama kategori', 'description' => 'Deskripsi'];
    }
}
