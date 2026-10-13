<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'supplier_id', 'sku', 'name', 'description',
        'price', 'stock', 'minimum_stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    // aturan stok dari P4: 0 = habis, <= minimum = menipis, selain itu aman
    public function statusStok(): string
    {
        if ($this->stock == 0) {
            return 'Habis';
        }

        return $this->stock <= $this->minimum_stock ? 'Menipis' : 'Aman';
    }
}
