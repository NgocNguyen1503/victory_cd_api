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
        "Chiếc laptop này được trang bị cấu hình mạnh mẽ với CPU đa nhân hiệu suất cao, kết hợp cùng card đồ họa rời thế hệ mới giúp xử lý mượt mà các tựa game AAA, phần mềm đồ họa 3D và ứng dụng mô phỏng nặng. Máy sở hữu bộ nhớ RAM dung lượng lớn cho khả năng đa nhiệm ổn định, ổ cứng SSD tốc độ cao mang lại thời gian khởi động cực nhanh và mở ứng dụng gần như tức thì. Hệ thống tản nhiệt được tối ưu giúp duy trì hiệu suất trong thời gian dài mà không gây nóng quá mức. Thiết kế hiện đại, chắc chắn, màn hình độ phân giải cao hỗ trợ dải màu rộng, phù hợp cả cho game thủ lẫn người làm sáng tạo nội dung.",
        "Laptop hướng đến nhu cầu văn phòng với thiết kế bền bỉ, trọng lượng nhẹ và thời lượng pin vượt trội, giúp người dùng làm việc liên tục nhiều giờ mà không cần sạc. Máy được trang bị bộ vi xử lý tiết kiệm điện nhưng vẫn đủ mạnh để xử lý các ứng dụng văn phòng, họp online và duyệt web mượt mà. Bàn phím êm, hành trình phím tốt hỗ trợ gõ lâu không mỏi tay. SSD cho tốc độ phản hồi nhanh và độ ổn định cao. Thiết bị cũng tối ưu khả năng kết nối với nhiều cổng thông dụng phục vụ học tập, làm việc từ xa, phù hợp với sinh viên, nhân viên văn phòng và người cần một chiếc máy tính đáng tin cậy.",
        "Điện thoại Android cao cấp sở hữu hệ thống camera chất lượng với cảm biến lớn, khả năng chụp đêm ấn tượng và nhiều chế độ xử lý ảnh thông minh. Màn hình sắc nét, tần số quét cao đem lại trải nghiệm giải trí mượt mà khi chơi game hoặc xem phim. Chip xử lý mạnh giúp chạy đa nhiệm tốt, kết hợp dung lượng pin lớn và sạc nhanh cho phép sử dụng cả ngày dài. Hệ điều hành Android linh hoạt, dễ tùy biến theo nhu cầu cá nhân. Máy cũng hỗ trợ nhiều công nghệ hiện đại như mở khóa sinh trắc học, kết nối 5G và âm thanh sống động, phù hợp cho người dùng yêu thích trải nghiệm toàn diện.",
        "Điện thoại iOS mang đến hiệu năng mạnh mẽ nhờ chip xử lý tối ưu, kết hợp hệ điều hành ổn định và mượt mà. Thiết kế tinh tế, hoàn thiện cao cấp cùng khả năng bảo mật nổi tiếng giúp bảo vệ dữ liệu cá nhân tốt hơn. Camera được tối ưu thuật toán, cho màu sắc tự nhiên và quay video chất lượng cao. Màn hình sắc nét, độ sáng cao, hiển thị tốt ngay cả dưới ánh nắng. Hệ sinh thái iOS cho phép đồng bộ liền mạch với các thiết bị khác, tạo nên trải nghiệm tiện lợi trong công việc và giải trí. Pin ổn định, sạc nhanh, phù hợp người dùng thích sự đơn giản nhưng hiệu quả.",
        "Tai nghe không dây này mang đến chất lượng âm thanh xuất sắc với dải âm cân bằng, bass sâu cùng khả năng chống ồn chủ động hiệu quả giúp bạn tập trung hơn khi làm việc hoặc thư giãn. Thiết kế gọn nhẹ, đeo thoải mái lâu dài, hỗ trợ điều khiển cảm ứng tiện lợi và kết nối Bluetooth ổn định. Pin sử dụng nhiều giờ, hộp sạc nhỏ gọn dễ mang theo. Tai nghe tương thích với hầu hết điện thoại, laptop và máy tính bảng. Phù hợp cho việc nghe nhạc, xem phim, chơi game hoặc gọi video nhờ micro thu âm rõ ràng và tính năng khử tiếng ồn môi trường.",
        "Chuột không dây được thiết kế mang lại thao tác mượt mà với cảm biến độ chính xác cao, phù hợp cho cả công việc văn phòng lẫn các tác vụ sáng tạo nhẹ. Pin bền, có thể dùng trong nhiều tháng chỉ với một lần sạc hoặc thay pin. Thiết kế ergonomic giảm mỏi cổ tay, hỗ trợ kết nối đa thiết bị giúp chuyển đổi giữa laptop, PC và máy tính bảng nhanh chóng. Chuột hoạt động êm ái, không gây tiếng động khi nhấp, phù hợp môi trường yên tĩnh. Tính năng tùy chỉnh nút bấm và độ nhạy cũng giúp người dùng tối ưu thao tác theo thói quen sử dụng."
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
            "Sản phẩm được hoàn thiện với chất lượng cao, từ vật liệu đến quy trình sản xuất, mang lại độ bền và sự an tâm khi sử dụng lâu dài. Thiết kế hiện đại, tinh tế và tối ưu về thẩm mỹ giúp thiết bị phù hợp với nhiều không gian và phong cách cá nhân khác nhau. Hiệu năng ổn định được đảm bảo nhờ phần cứng tối ưu, cho phép vận hành mượt mà các tác vụ thường ngày như lướt web, xem phim hay làm việc văn phòng. Bên cạnh đó, thiết bị cũng hạn chế tối đa tình trạng giật lag, giúp người dùng có trải nghiệm liền mạch. Đây là lựa chọn lý tưởng cho những ai muốn sở hữu một sản phẩm vừa đẹp, vừa bền và hoạt động đáng tin cậy.",
            "Thiết bị được thiết kế để đáp ứng tốt nhiều nhu cầu khác nhau, từ học tập cho đến làm việc và giải trí. Với khả năng xử lý ổn định, người dùng có thể sử dụng các ứng dụng văn phòng, họp trực tuyến, ghi chép tài liệu hay học online một cách mượt mà. Khi cần giải trí, máy cũng hỗ trợ xem phim, nghe nhạc, lướt mạng xã hội và chơi một số tựa game phổ thông mà không gặp trở ngại. Giao diện dễ dùng, kết nối ổn định và thời lượng pin tốt giúp thiết bị trở thành công cụ đồng hành đáng tin cậy cho học sinh, sinh viên và nhân viên văn phòng. Tính linh hoạt cao khiến sản phẩm này phù hợp cho mọi môi trường, từ lớp học đến nơi làm việc.",
            "Thiết bị sở hữu hiệu năng mạnh mẽ nhờ bộ xử lý tối ưu, cho phép mở nhiều ứng dụng cùng lúc mà vẫn giữ được sự mượt mà. Dung lượng lưu trữ lớn giúp người dùng thoải mái cài đặt phần mềm, lưu trữ hình ảnh, tài liệu và các dữ liệu quan trọng khác mà không lo đầy bộ nhớ quá nhanh. Pin bền bỉ là điểm mạnh nổi bật, hỗ trợ sử dụng liên tục trong nhiều giờ chỉ với một lần sạc, phù hợp cho người thường xuyên di chuyển hoặc làm việc ngoài trời. Khả năng tiết kiệm năng lượng cũng được cải thiện, giúp tăng thời lượng sử dụng tổng thể. Đây là lựa chọn lý tưởng cho người dùng cần một thiết bị mạnh, lưu trữ tốt và pin lâu dài.",
            "Sản phẩm có thiết kế tinh tế với đường nét gọn gàng, chất liệu đẹp mắt và cảm giác cao cấp khi cầm nắm. Giao diện và cách bố trí tính năng được tối ưu để người mới cũng dễ dàng tiếp cận và sử dụng, giảm thời gian làm quen. Nhờ tính linh hoạt cao, thiết bị phù hợp với nhiều đối tượng sử dụng, từ người dùng phổ thông, học sinh – sinh viên cho đến nhân viên văn phòng. Nó đáp ứng tốt các nhu cầu thường ngày như làm việc, học tập, xem phim, truy cập internet và liên lạc. Sự kết hợp giữa vẻ ngoài thẩm mỹ và trải nghiệm sử dụng thân thiện giúp thiết bị trở thành lựa chọn hài hòa giữa phong cách và công năng.",
            "Thiết bị được tích hợp những công nghệ mới nhất, mang lại trải nghiệm hiện đại và tiện lợi cho người dùng. Các tính năng thông minh như kết nối nhanh, bảo mật nâng cao, điều khiển tự động hoặc đồng bộ dữ liệu giúp tối ưu quy trình sử dụng hằng ngày. Hệ thống cảm biến và phần mềm được thiết kế để hoạt động khéo léo trong nhiều tình huống, từ giải trí cho đến làm việc. Việc hỗ trợ các chuẩn kết nối mới cũng giúp thiết bị tương thích tốt với nhiều loại phụ kiện và dịch vụ. Nhờ sự kết hợp giữa phần cứng tiên tiến và tính năng thông minh, sản phẩm mang đến trải nghiệm mượt mà, tiết kiệm thời gian và tăng hiệu quả sử dụng."
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
