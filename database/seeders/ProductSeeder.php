<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '2G');
        DB::disableQueryLog();

        $now = Carbon::now()->toDateTimeString();
        $userIds = DB::table('users')->pluck('id')->toArray();

        $totalProducts = 50000;
        $chunkSize = 2000;

        for ($i = 0; $i < $totalProducts; $i += $chunkSize) {
            $products = [];
            for ($j = 1; $j <= $chunkSize; $j++) {
                $num = $i + $j;
                $products[] = [
                    'user_id' => $userIds[array_rand($userIds)],
                    'title' => 'Product ' . $num,
                    'slug' => 'product-' . $num,
                    'short_description' => 'This is product ' . $num,
                    'price' => rand(100, 10000),
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('products')->insert($products);
            echo "Inserted products: " . ($i + $chunkSize) . "\n";
        }
    }
}
