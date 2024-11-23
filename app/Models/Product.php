<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'products';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'title',
        'category_id',
        'price',
        'stock',
        'brand',
        'berat',
        'satuan',
        'deskripsi',
        'foto',
    ];

    // Relasi dengan OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }
}
