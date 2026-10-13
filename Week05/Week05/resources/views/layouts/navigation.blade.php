<header class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('dashboard') }}" class="brand">Inventory</a>

        <nav class="menu">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Produk</a>
            <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori</a>
            <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">Supplier</a>
            <a href="{{ route('stock-movements.index') }}" class="{{ request()->routeIs('stock-movements.*') ? 'active' : '' }}">Stok</a>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="logout">
            @csrf
            <span>{{ auth()->user()->name }}</span>
            <button type="submit" class="btn btn-small btn-light">Keluar</button>
        </form>
    </div>
</header>
