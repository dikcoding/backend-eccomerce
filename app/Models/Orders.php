<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'orders';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'customer_id',
        'status',
        'total_price',
    ];

    // Relasi dengan OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
