<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;

class ProductTest extends TestCase
{

    public function testCreateProductSuccess()
    {
        //
        $this->seed([UserSeeder::class]);
        $this->seed([CategorySeeder::class]);

        $this->post(
            '/api/products',
            [
                'title' => 'Meja Kayu',
                'category_id' => 1,
                'price' => 1500000,
                'stock' => 10,
                'brand' => 'Envi',
                'berat' => 1,
                'satuan' => 'Kg',
                'deskripsi' => 'Cat berwarna kuning dan tahan lama',
                'foto' => "test.jpg",
                'user_id' => 1
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(201)->assertJson([
            "data" => [
                'title' => 'Meja Kayu',
                'category_id' => 1,
                'price' => 1500000,
                'stock' => 10,
                'brand' => 'Envi',
                'berat' => 1,
                'satuan' => 'Kg',
                'deskripsi' => 'Cat berwarna kuning dan tahan lama',
                'foto' => 'cat.jpeg',
                'foto' => "test.jpg",
                'user_id' => 1
            ]
        ]);
    }
}
