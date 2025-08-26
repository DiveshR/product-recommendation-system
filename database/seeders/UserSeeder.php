<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '2G');
        DB::disableQueryLog();

        $now = Carbon::now()->toDateTimeString();
        $totalUsers = 20000;
        $chunkSize = 1000;

        for ($i = 0; $i < $totalUsers; $i += $chunkSize) {
            $users = [];
            for ($j = 1; $j <= $chunkSize; $j++) {
                $num = $i + $j;
                $users[] = [
                    'username' => 'user' . $num,
                    'first_name' => 'First' . $num,
                    'last_name' => 'Last' . $num,
                    'email' => 'user' . $num . '@example.com',
                    'dial_code' => '+91',
                    'iso2' => 'IN',
                    'phone' => '9' . str_pad($num, 9, '0', STR_PAD_LEFT),
                    'email_verified_at' => $now,
                    'password' => bcrypt('password'),
                    'role_id' => 2,
                    'user_type' => 'customer',
                    'status' => 1,
                    'terms_accepted' => 1,
                    'remember_token' => Str::random(10),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            DB::table('users')->insert($users);
            echo "Inserted users: " . ($i + $chunkSize) . "\n";
        }
    }
}
