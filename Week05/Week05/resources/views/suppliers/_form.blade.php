<div class="form-grid">
    <div class="form-group">
        <label for="name">Nama Supplier</label>
        <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}">
        @error('name') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="phone">No. Telepon</label>
        <input type="text" id="phone" name="phone" value="{{ old('phone', $supplier->phone) }}">
        @error('phone') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="{{ old('email', $supplier->email) }}">
        @error('email') <small class="error">{{ $message }}</small> @enderror
    </div>

    <div class="form-group">
        <label for="address">Alamat</label>
        <input type="text" id="address" name="address" value="{{ old('address', $supplier->address) }}">
        @error('address') <small class="error">{{ $message }}</small> @enderror
    </div>
</div>
