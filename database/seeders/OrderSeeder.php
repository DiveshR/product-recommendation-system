<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '2G');
        DB::disableQueryLog();

        $now = Carbon::now()->toDateTimeString();
        $userIds = DB::table('users')->pluck('id')->toArray();
        $productData = DB::table('products')->select('id', 'price')->get()->toArray();

        $totalOrders = 10000;
        $chunkSize = 1000;

        for ($i = 0; $i < $totalOrders; $i += $chunkSize) {
            $orders = [];
            for ($j = 1; $j <= $chunkSize; $j++) {
                $num = $i + $j;
                $product = $productData[array_rand($productData)];
                $quantity = rand(1, 5);
                $orders[] = [
                    'user_id' => $userIds[array_rand($userIds)],
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'total' => $quantity * $product->price,
                    'status' => ['pending', 'completed', 'cancelled'][rand(0, 2)],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('orders')->insert($orders);
            echo "Inserted orders: " . ($i + $chunkSize) . "\n";
        }
    }
}
