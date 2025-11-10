<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    private $names = [
        "Laptop Gaming Asus ROG",
        "Laptop Dell Inspiron",

        "Điện thoại Samsung Galaxy S23",

        "Điện thoại iPhone 14",

        "Tai nghe Bluetooth Sony",
        "Chuột Logitech MX Master",
    ];

    private $descriptions = [
        "Laptop cấu hình mạnh, phù hợp chơi game AAA và xử lý đồ họa nặng.",
        "Laptop văn phòng bền, pin lâu, thích hợp học tập và làm việc.",

        "Điện thoại Android cao cấp với camera chất lượng và màn hình đẹp.",
        "Điện thoại iOS mạnh mẽ, thiết kế tinh tế và bảo mật cao.",

        "Tai nghe không dây chất lượng âm thanh xuất sắc, chống ồn tốt.",
        "Chuột không dây cho thao tác mượt mà, pin lâu, hỗ trợ đa thiết bị."
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 2; $i++) {
            DB::table('products')->insert([
                'name' => $this->names[$i],
                'category_id' => 7,
                'description' => $this->descriptions[$i],
                'price' => 10000,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->names[$i] . '.jpg',
                'quantity' => random_int(0, 50),
                'total_sold' => random_int(1, 100),
                'score' => random_int(3, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        for ($i = 2; $i < 3; $i++) {
            DB::table('products')->insert([
                'name' => $this->names[$i],
                'category_id' => 8,
                'description' => $this->descriptions[$i],
                'price' => 10000,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->names[$i] . '.jpg',
                'quantity' => random_int(0, 50),
                'total_sold' => random_int(1, 100),
                'score' => random_int(3, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 3; $i < 4; $i++) {
            DB::table('products')->insert([
                'name' => $this->names[$i],
                'category_id' => 9,
                'description' => $this->descriptions[$i],
                'price' => 10000,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->names[$i] . '.jpg',
                'quantity' => random_int(0, 50),
                'total_sold' => random_int(1, 100),
                'score' => random_int(3, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 4; $i < 5; $i++) {
            DB::table('products')->insert([
                'name' => $this->names[$i],
                'category_id' => 10,
                'description' => $this->descriptions[$i],
                'price' => 10000,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->names[$i] . '.jpg',
                'quantity' => random_int(0, 50),
                'total_sold' => random_int(1, 100),
                'score' => random_int(3, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 5; $i < 6; $i++) {
            DB::table('products')->insert([
                'name' => $this->names[$i],
                'category_id' => 11,
                'description' => $this->descriptions[$i],
                'price' => 10000,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->names[$i] . '.jpg',
                'quantity' => random_int(0, 50),
                'total_sold' => random_int(1, 100),
                'score' => random_int(3, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
