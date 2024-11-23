<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'order_items';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relasi dengan Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Relasi dengan Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
