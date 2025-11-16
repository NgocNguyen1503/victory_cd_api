<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    private $titles = [
        'Laptop',
        'Điện thoại',
        'Phụ kiện',
        'Thiết bị thông minh',
        'Tablet',

        'Laptop Gaming',
        'Laptop Văn phòng',

        'Điện thoại Android',
        'Điện thoại iOS',

        'Tai nghe',
        'Chuột',
        'Bàn phím',
        'Ổ cứng',
        'USB',

        'Camera',
        'Loa',
        'Smartwatch',
        'Thiết bị đo sức khỏe',
        'Drone',
        'Robot hút bụi',

        'Tablet Android',
        'Tablet iOS'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 0,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->titles[$i] . '.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 5; $i < 7; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 1,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->titles[$i] . '.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 7; $i < 9; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 2,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->titles[$i] . '.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 9; $i < 14; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 3,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->titles[$i] . '.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 14; $i < 20; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 4,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->titles[$i] . '.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 20; $i < 22; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 5,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->titles[$i] . '.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
