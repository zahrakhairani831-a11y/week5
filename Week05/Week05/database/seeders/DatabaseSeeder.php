<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Zahra Khairani',
            'email'    => 'admin@inventory.test',
            'password' => Hash::make('password123'),
        ]);

        $kategori = [
            ['Elektronik', 'Perangkat dan aksesoris elektronik'],
            ['Alat Tulis', 'Perlengkapan menulis dan kantor'],
            ['Makanan', 'Makanan ringan dan kemasan'],
            ['Minuman', 'Minuman kemasan'],
            ['Perabot', 'Furnitur dan perlengkapan ruangan'],
        ];

        foreach ($kategori as [$nama, $deskripsi]) {
            Category::create(['name' => $nama, 'description' => $deskripsi]);
        }

        Supplier::factory(5)->create();
        Product::factory(40)->create();
    }
}
