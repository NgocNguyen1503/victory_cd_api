<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    private $names = [
        "Kumiko Yokoi Hát Tại Hà Nội",
        "felicia's Folk Music",

        "Tuấn Ngọc - Trịnh Công Sơn",
        "80 Năm Một Cuộc Đời"
    ];

    private $descriptions = [
        "Nữ ca sĩ Nhật Bản Yokoi Kumiko có niềm mong muốn tại Việt Nam là những bài hát của cô sẽ giúp mang lại niềm vui cho những trẻ em bị dị tật vì chất độc da cam.",
        "Album bao gồm 14 bản tình ca nổi tiếng thế giới, được Felicia Wong hát lại bằng tiếng Anh cùng cây Guitar thùng cực kỳ cuốn hút.",

        "Không có mô tả",
        "Em ơi em ơi, tám mươi năm hay một trăm năm. Đời người ngắn lắm, hãy sống cho trọn vẹn từng ngày"
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
                'description' => "",
                'price' => 10000,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->names[$i] . '.jpg',
                'quantity' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 2; $i < 4; $i++) {
            DB::table('products')->insert([
                'name' => $this->names[$i],
                'category_id' => 8,
                'description' => "",
                'price' => 10000,
                'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $this->names[$i] . '.jpg',
                'quantity' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
