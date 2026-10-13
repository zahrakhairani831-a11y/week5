# Inventory Management System (Laravel)

**PemrogramanWeb_Zahra Khairani_250180073**

Tugas Pertemuan 5 - Laravel Fundamental.
Project ini adalah hasil migrasi Inventory Management System dari Pertemuan 4 (PHP native) ke framework Laravel. Struktur database dan aturan bisnis stok tetap sama, yang berubah hanya cara mengorganisasi kodenya (MVC).

## Fitur

- Login dan logout (Laravel Auth)
- CRUD produk (resource controller)
- CRUD kategori dan supplier
- Relasi Eloquent: Category hasMany Product, Product belongsTo Category dan Supplier
- Listing produk dengan search, filter kategori, filter status stok, sorting, dan pagination
- Transaksi stok masuk dan keluar beserta riwayatnya
- Dashboard ringkasan stok

## Aturan bisnis stok (dari P4)

- Stok awal diisi sekali saat produk dibuat, setelah itu stok hanya berubah lewat transaksi stok.
- Stok keluar tidak boleh melebihi stok yang tersedia.
- Status stok: **Habis** jika stok 0, **Menipis** jika stok <= stok minimum, selain itu **Aman**.
- Kategori yang masih punya produk tidak bisa dihapus.
- SKU produk harus unik.

## Cara instalasi

Syarat: PHP 8.2+, Composer, MySQL (XAMPP / Laragon juga bisa).

Folder ini berisi file-file yang saya buat (app, database, resources, routes, public/css). Agar bisa dijalankan, letakkan di atas project Laravel baru:

```bash
# 1. buat project laravel baru
composer create-project laravel/laravel inventory-laravel

# 2. salin isi folder ini ke dalam inventory-laravel, timpa file yang sama
#    (app, database, resources, routes, public, .env.example)

cd inventory-laravel

# 3. siapkan .env
cp .env.example .env
php artisan key:generate

# 4. buat database kosong bernama inventory_db di MySQL
#    (lewat phpMyAdmin atau: CREATE DATABASE inventory_db;)
#    lalu cek DB_USERNAME dan DB_PASSWORD di .env sesuai komputer masing-masing

# 5. jalankan migration dan seeder
php artisan migrate:fresh --seed

# 6. jalankan server
php artisan serve
```

Buka http://127.0.0.1:8000 di browser.

Akun login (dari seeder):

| Email | Password |
|-------|----------|
| admin@inventory.test | password123 |

## Struktur file penting

```
app/Models/              Category, Supplier, Product, StockMovement
app/Http/Controllers/    Product, Category, Supplier, StockMovement, Dashboard, Auth
database/migrations/     categories, suppliers, products, stock_movements
database/factories/      SupplierFactory, ProductFactory
database/seeders/        DatabaseSeeder
resources/views/         layouts, components, products, categories, suppliers, stock, auth
routes/web.php           semua route aplikasi
public/css/style.css     styling
```

## Penjelasan arsitektur MVC

Alur satu request di project ini:

**Request -> Route -> Controller -> Model -> Database -> Response**

- **Route** (`routes/web.php`) menerima URL dan HTTP method, lalu meneruskannya ke method controller yang sesuai. Produk memakai `Route::resource('products', ProductController::class)`.
- **Controller** (`app/Http/Controllers`) mengatur alur: menerima input, memvalidasi, memanggil model, lalu memilih response (view atau redirect). Business logic transaksi stok ada di `StockMovementController`, bukan di Blade.
- **Model** (`app/Models`) mewakili tabel dan menyediakan akses database lewat Eloquent. Relasi antar tabel didefinisikan di sini, misalnya `Product::category()` dan `Category::products()`.
- **View** (`resources/views`) hanya menampilkan data. Semua halaman memakai layout `layouts/app.blade.php`, ditambah component `x-alert` dan `x-sort-link`.

### Contoh alur lengkap: tambah produk

1. Buka `/products/create` -> `ProductController@create` menampilkan form Blade.
2. Form dikirim (POST `/products`, dengan `@csrf`) -> `ProductController@store`.
3. Input divalidasi. Jika gagal, user dikembalikan ke form beserta pesan error dan nilai lama (`old()`).
4. Jika lolos, `Product::create()` menyimpan data ke database (dalam DB transaction, bersama catatan stok awal).
5. Redirect ke `products.index` dengan flash message "Produk berhasil disimpan."
6. Halaman daftar produk menampilkan data terbaru.

## Perbandingan P4 dan P5

| P4 (PHP Native) | P5 (Laravel) |
|---|---|
| database/schema.sql | database/migrations |
| Form PHP manual | Blade form + validasi |
| Query PDO | Eloquent |
| File CRUD terpisah | Resource controller |
| Session manual | Laravel Auth |
| include template | Blade layout dan component |

## Daftar screenshot untuk dikumpulkan

1. Output `php artisan route:list`
2. Halaman login
3. Daftar produk (search / filter / sorting / pagination)
4. Form tambah produk dengan pesan validasi error
5. Daftar produk setelah berhasil simpan (flash message)
6. Edit dan hapus produk
7. Halaman kategori dan supplier
8. Transaksi stok keluar yang ditolak karena stok kurang
9. Hasil `php artisan migrate:fresh --seed` di terminal
