<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
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

    public function testGetSuccess()
    {
        $this->seed([UserSeeder::class, CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->limit(1)->first();

        $this->get('api/products/' . $product->id, [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'Meja Kayu',
                    'category_id' => 1,
                    'price' => 1500000,
                    'stock' => 10,
                    'brand' => 'Envi',
                    'berat' => 1,
                    'satuan' => 'Kg',
                    'deskripsi' => 'Cat berwarna kuning dan tahan lama',
                    'foto' => 'cat.jpeg',
                    'user_id' => 1
                ]
            ]);
    }

    public function testGetNotFound()
    {
        $this->seed([UserSeeder::class, CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->limit(1)->first();

        $this->get('api/products/' . ($product->id + 1), [
            'Authorization' => 'test'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'not found'
                    ]
                ]
            ]);
    }

    public function testUpdateSuccess()
    {
        $this->seed([UserSeeder::class, CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->limit(1)->first();

        $this->put('api/products/' . $product->id, [
            'title' => 'Cat Envi',
            'category_id' => 1,
            'price' => 1000000,
            'stock' => 20,
            'brand' => 'Kuda Terbang',
            'berat' => 2,
            'satuan' => 'L',
            'deskripsi' => 'Cat berwarna merah',
            'foto' => 'Envi.jpeg',
            'user_id' => 1
        ], [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title' => 'Cat Envi',
                    'category_id' => 1,
                    'price' => 1000000,
                    'stock' => 20,
                    'brand' => 'Kuda Terbang',
                    'berat' => 2,
                    'satuan' => 'L',
                    'deskripsi' => 'Cat berwarna merah',
                    'foto' => 'Envi.jpeg',
                    'user_id' => 1
                ]
            ]);
    }

    public function testUpdateValidationError()
    {
        $this->seed([UserSeeder::class, CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->limit(1)->first();

        $this->put('api/products/' . $product->id, [
            'title' => '',
            'category_id' => 1,
            'price' => 1000000,
            'stock' => 20,
            'brand' => 'Kuda Terbang',
            'berat' => 2,
            'satuan' => 'L',
            'deskripsi' => 'Cat berwarna merah',
            'foto' => 'Envi.jpeg',
            'user_id' => 1
        ], [
            'Authorization' => 'test'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'title' => [
                        'The title field is required.'
                    ]
                ]
            ]);
    }

    public function testDeleteSuccess()
    {
        $this->seed([UserSeeder::class, CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->limit(1)->first();

        $this->delete('api/products/' . $product->id, [], [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }

    public function testDeleteNotFound()
    {
        $this->seed([UserSeeder::class, CategorySeeder::class, ProductSeeder::class]);
        $product = Product::query()->limit(1)->first();

        $this->delete('api/products/' . ($product->id + 1), [], [
            'Authorization' => 'test'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    "message" => [
                        "not found"
                    ]
                ]
            ]);
    }
}
