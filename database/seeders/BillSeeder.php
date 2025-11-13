<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        // Mặc định có 3 user trong UserSeeder
        $userCount = DB::table('users')->count();

        for ($i = 1; $i <= $userCount; $i++) {
            // Mỗi user tạo 3 đơn hàng
            for ($j = 0; $j < 3; $j++) {
                $status = rand(3, 6); // paid → done
                $total = rand(2000000, 20000000);

                DB::table('bills')->insert([
                    'user_id' => $i,
                    'order_code' => rand(100000, 999999),
                    'total_price' => $total,
                    'status' => $status,
                    'payment_method' => rand(0, 1),
                    'address' => '123 Đường ABC, Quận 1, TP.HCM',
                    'phone' => '090' . rand(1000000, 9999999),
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
