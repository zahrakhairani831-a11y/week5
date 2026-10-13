<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $jenis = ['Mouse', 'Keyboard', 'Headset', 'Flashdisk', 'Kabel HDMI', 'Buku Tulis',
                  'Pulpen', 'Spidol', 'Map Folder', 'Kopi Sachet', 'Teh Botol', 'Air Mineral',
                  'Kursi Lipat', 'Rak Buku', 'Lampu Meja'];
        $varian = ['Standar', 'Premium', 'Mini', 'Pro', 'Eco', 'Plus'];

        return [
            'category_id'   => Category::inRandomOrder()->value('id'),
            'supplier_id'   => Supplier::inRandomOrder()->value('id'),
            'sku'           => fake()->unique()->bothify('SKU-####'),
            'name'          => fake()->randomElement($jenis) . ' ' . fake()->randomElement($varian),
            'description'   => fake()->sentence(8),
            'price'         => fake()->numberBetween(5, 500) * 1000,
            'stock'         => fake()->numberBetween(0, 100),
            'minimum_stock' => fake()->numberBetween(5, 15),
        ];
    }

    // tiap produk hasil seeder dikasih riwayat stok awal
    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            if ($product->stock > 0) {
                StockMovement::create([
                    'product_id'   => $product->id,
                    'type'         => 'in',
                    'quantity'     => $product->stock,
                    'stock_before' => 0,
                    'stock_after'  => $product->stock,
                    'note'         => 'Stok awal produk',
                ]);
            }
        });
    }
}
