<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('username', 'test')->first();
        if ($user) {
            Order::create([
                'id' => 1,
                'customer_id' => 1,
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        } else {
            $this->command->info('Pengguna dengan username "test" tidak ditemukan.');
        }
    }
}
