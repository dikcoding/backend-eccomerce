<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // Import model Product
use Carbon\Carbon; // Untuk format tanggal

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'title' => 'Meja Kayu',
            'category_id' => 1,
            'price' => 1500000,
            'stock' => 10,
            'brand' => 'Envi',
            'berat' => 1,
            'satuan' => 'Kg',
            'deskripsi' => 'Cat berwarna kuning dan tahan lama',
            'foto' => 'cat.jpeg',
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
