<div class="form-grid">
    <div class="form-group">
        <label for="sku">SKU</label>
        <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
        @error('sku') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="name">Nama Produk</label>
        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}">
        @error('name') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="category_id">Kategori</label>
        <select id="category_id" name="category_id">
            <option value="">-- pilih kategori --</option>
            @foreach ($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
        @error('category_id') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="supplier_id">Supplier <span class="muted">(opsional)</span></label>
        <select id="supplier_id" name="supplier_id">
            <option value="">-- tanpa supplier --</option>
            @foreach ($suppliers as $s)
                <option value="{{ $s->id }}" @selected(old('supplier_id', $product->supplier_id) == $s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
        @error('supplier_id') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="price">Harga (Rp)</label>
        <input type="number" id="price" name="price" step="0.01" value="{{ old('price', $product->price) }}">
        @error('price') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="minimum_stock">Stok Minimum</label>
        <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock ?? 5) }}">
        @error('minimum_stock') <small class="error">{{ $message }}</small> @enderror
    </div>

    @unless ($product->exists)
        <div class="form-group">
            <label for="stock">Stok Awal</label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}">
            @error('stock') <small class="error">{{ $message }}</small> @enderror
        </div>
    @endunless
</div>

<div class="form-group">
    <label for="description">Deskripsi <span class="muted">(opsional)</span></label>
    <textarea id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
    @error('description') <small class="error">{{ $message }}</small> @enderror
</div>

@if ($product->exists)
    <p class="muted">Stok tidak diubah dari sini. Gunakan menu <a href="{{ route('stock-movements.create', ['product' => $product->id]) }}">transaksi stok</a>.</p>
@endif
