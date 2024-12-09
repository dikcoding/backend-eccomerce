<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\OrderSeeder;
use App\Models\Order;
use Database\Seeders\CategorySeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrderSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->seed([CategorySeeder::class]);
        $this->seed([ProductSeeder::class]);

        $this->post(
            '/api/orders',
            [
                'customer_id' => 1,
                'status' => 'pending'
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(201)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'customer_id' => 1,
                    'status' => 'pending'
                ]
            ]);
    }

    public function testGetOrderSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->seed([CategorySeeder::class]);
        $this->seed([OrderSeeder::class]);

        $order = Order::query()->limit(1)->first();

        $this->get('api/orders/' . $order->id, [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'customer_id' => 1,
                    'status' => 'pending'
                ]
            ]);
    }

    public function testGetAllOrderSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->seed([CategorySeeder::class]);
        $this->seed([OrderSeeder::class]);

        $this->get('api/orders/', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'customer_id' => 1,
                    'status' => 'pending'
                ]
            ]);
    }

    public function testGetOrderNotFound()
    {
        $this->seed([UserSeeder::class]);
        $this->seed([CategorySeeder::class]);
        $this->seed([OrderSeeder::class]);

        $order = Order::query()->limit(1)->first();

        $this->get('api/orders/' . ($order->id + 1), [
            'Authorization' => 'test'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'Order not found'
                    ]
                ]
            ]);
    }
}
