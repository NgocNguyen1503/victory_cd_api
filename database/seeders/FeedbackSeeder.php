<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class FeedbackSeeder extends Seeder
{
    public function run(): void
    {
        $bills = DB::table('bills')->pluck('id');
        $users = DB::table('users')->pluck('id');

        $comments = [
            'Sản phẩm rất tốt, đúng mô tả!',
            'Giao hàng nhanh, đóng gói cẩn thận.',
            'Hài lòng với chất lượng, sẽ ủng hộ tiếp.',
            'Giá hợp lý, dịch vụ tốt.',
            'Sản phẩm ổn, nhưng giao hơi chậm.',
            'Không như mong đợi lắm.',
        ];

        foreach ($bills as $bill_id) {
            // 70% hóa đơn có feedback
            if (rand(1, 100) <= 70) {
                DB::table('feedbacks')->insert([
                    'type' => 0, // đánh giá
                    'bill_id' => $bill_id,
                    'score' => rand(3, 5),
                    'comment' => $comments[array_rand($comments)],
                    'user_id' => $users->random(),
                    'status' => 1, // đã duyệt
                    'created_at' => Carbon::now()->subDays(rand(0, 15)),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
