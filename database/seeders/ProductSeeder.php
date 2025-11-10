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
        "80 Năm Một Cuộc Đời",

        "Cassette - Garth Brooks – The Hits",
        "Cassette - Various – Country's Greatest Hits Volume 1 Blazin' Country",
    ];

    private $descriptions = [
        "Nữ ca sĩ Nhật Bản Yokoi Kumiko có niềm mong muốn tại Việt Nam là những bài hát của cô sẽ giúp mang lại niềm vui cho những trẻ em bị dị tật vì chất độc da cam.",
        "Album bao gồm 14 bản tình ca nổi tiếng thế giới, được Felicia Wong hát lại bằng tiếng Anh cùng cây Guitar thùng cực kỳ cuốn hút.",

        "Không có mô tả",
        "Em ơi em ơi, tám mươi năm hay một trăm năm. Đời người ngắn lắm, hãy sống cho trọn vẹn từng ngày",

        "Ca sĩ kiêm nhạc sĩ nhạc đồng quê người Mỹ Garth Brooks đã phát hành 16 album phòng thu, hai album trực tiếp và 63 đĩa đơn.",
        "Một bộ sưu tập bao gồm 10 bản hit từ những năm 80, tập trung vào các bản nhạc rock sôi động và nhạc honky tonker."
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

        for ($i = 2; $i < 4; $i++) {
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

        for ($i = 4; $i < 6; $i++) {
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
    }
}
