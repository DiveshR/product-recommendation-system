<?php

// app/Console/Commands/ExportData.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportData extends Command
{
    protected $signature = 'export:data';
    protected $description = 'Export orders, users, products for ML';

    public function handle()
    {
        $orders = DB::table('orders')->select('user_id', 'product_id', 'quantity')->get();
        file_put_contents(storage_path('orders.json'), $orders->toJson());

        $products = DB::table('products')->select('id', 'title', 'slug', 'price')->get();
        file_put_contents(storage_path('products.json'), $products->toJson());

        $this->info('Data exported successfully.');
    }
}
