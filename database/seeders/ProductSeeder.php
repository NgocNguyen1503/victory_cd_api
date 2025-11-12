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
                'total_sold' => random_int(200, 500),
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
                'total_sold' => random_int(200, 500),
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
                'total_sold' => random_int(200, 500),
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
                'total_sold' => random_int(200, 500),
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
                'total_sold' => random_int(200, 500),
                'score' => random_int(3, 5),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        $extraProducts = [
            7 => ["Laptop Acer Aspire 5", "Laptop HP Pavilion", "Laptop Lenovo ThinkPad", "Laptop Asus Vivobook", "Laptop MSI Modern 15"],
            8 => ["Xiaomi Redmi Note 13", "Oppo Find X6", "Vivo V30", "Realme GT 6", "OnePlus 12"],
            9 => ["iPhone 13", "iPhone 15 Pro", "iPhone SE 2022", "iPhone 15 Plus", "iPhone 14 Pro Max"],
            10 => ["Tai nghe AirPods Pro", "Tai nghe JBL Tune 760NC", "Tai nghe Beats Studio", "Tai nghe Sennheiser HD450BT", "Tai nghe Razer Kraken"],
            11 => ["Chuột Razer DeathAdder", "Chuột Microsoft Arc", "Chuột Apple Magic Mouse", "Chuột Corsair Harpoon", "Chuột SteelSeries Rival 5"],
            12 => ["Bàn phím cơ Keychron K6", "Bàn phím Logitech MX Keys", "Bàn phím Razer BlackWidow", "Bàn phím Corsair K70", "Bàn phím Apple Magic Keyboard"],
            13 => ["SSD Samsung 1TB", "HDD Seagate 2TB", "SSD Kingston 512GB", "SSD WD Blue 1TB", "HDD Toshiba 1TB"],
            14 => ["USB SanDisk 32GB", "USB Kingston 64GB", "USB Transcend 128GB", "USB Samsung BAR Plus 64GB", "USB Lexar 256GB"],
            15 => ["Camera Canon EOS 200D", "Camera Sony Alpha A7", "Camera Nikon D5600", "Camera Fujifilm X-T30", "Camera GoPro Hero 12"],
            16 => ["Loa Bluetooth JBL Charge 5", "Loa Sony SRS-XB43", "Loa Bose SoundLink Mini", "Loa Marshall Emberton", "Loa Anker Soundcore 3"],
            17 => ["Apple Watch Series 9", "Samsung Galaxy Watch 6", "Huawei Watch GT4", "Xiaomi Watch S1", "Garmin Venu 3"],
            18 => ["Vòng đeo tay Mi Band 8", "Thiết bị đo huyết áp Omron", "Cân sức khỏe Xiaomi", "Máy đo SpO2 Beurer", "Thiết bị đo nhịp tim Fitbit"],
            19 => ["Drone DJI Mini 4 Pro", "Drone Autel Evo Nano", "Drone Ryze Tello", "Drone FIMI X8 SE", "Drone Potensic D88"],
            20 => ["Robot hút bụi Xiaomi Gen 4", "Robot hút bụi Ecovacs T20", "Robot hút bụi iRobot Roomba j7", "Robot hút bụi Dreame L20", "Robot hút bụi Roborock S8"],
            21 => ["Tablet Samsung Tab S9", "Tablet Xiaomi Pad 6", "Tablet Lenovo Tab P12", "Tablet Huawei MatePad 11", "Tablet Oppo Pad Air"]
        ];

        $descriptions = [
            "Sản phẩm chất lượng cao, thiết kế hiện đại và hiệu năng ổn định.",
            "Thiết bị phù hợp cho học tập, làm việc và giải trí.",
            "Hiệu năng mạnh mẽ, dung lượng lưu trữ lớn, pin bền.",
            "Thiết kế tinh tế, dễ sử dụng, phù hợp nhiều nhu cầu.",
            "Công nghệ mới nhất, hỗ trợ nhiều tính năng thông minh."
        ];

        foreach ($extraProducts as $category_id => $names) {
            foreach ($names as $name) {
                DB::table('products')->insert([
                    'name' => $name,
                    'category_id' => $category_id,
                    'description' => $descriptions[array_rand($descriptions)],
                    'price' => random_int(2000000, 50000000),
                    'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . str_replace(' ', '%20', $name) . '.jpg',
                    'quantity' => random_int(0, 100),
                    'total_sold' => random_int(10, 200),
                    'score' => random_int(3, 5),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
