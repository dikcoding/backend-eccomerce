<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'categories';

    // Kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'nama',
    ];

    // Relasi dengan OrderItem
    public function Products()
    {
        return $this->hasMany(Product::class, 'categories_id');
    }
}
