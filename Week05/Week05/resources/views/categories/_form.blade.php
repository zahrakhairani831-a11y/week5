<div class="form-group">
    <label for="name">Nama Kategori</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}">
    @error('name') <small class="error">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi <span class="muted">(opsional)</span></label>
    <input type="text" id="description" name="description" value="{{ old('description', $category->description) }}">
    @error('description') <small class="error">{{ $message }}</small> @enderror
</div>
