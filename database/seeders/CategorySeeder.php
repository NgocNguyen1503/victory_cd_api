<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    private $titles = [
        'Đĩa than',
        'Cassette',
        'CD nhạc việt',
        'CD nhạc quốc tế',
        'CD hải ngoại',
        'Giới thiệu',

        'Đĩa than quốc tế',
        'Đĩa than Việt Nam',

        'Cassette quốc tế',
        'Cassette trong nước',

        'Nhạc trẻ',
        'Nhạc trữ tình',
        'Nhạc vàng',
        'Nhạc tiền chiến',
        'Thơ ca, quan họ',

        'Nhạc đồng quê',
        'Nhạc cổ điển (Classic)',
        'Pop',
        'Rock',
        'Jazz',
        'Blues',

        'CD thời kỳ 1975',
        'CD nhạc vàng'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 6; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 6; $i < 8; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 8; $i < 10; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 10; $i < 15; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 15; $i < 21; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 21; $i < 23; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
