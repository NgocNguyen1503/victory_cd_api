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
        for ($i = 0; $i < 5; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 5; $i < 7; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 7; $i < 9; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 9; $i < 14; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 14; $i < 20; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        for ($i = 20; $i < 22; $i++) {
            DB::table('categories')->insert([
                'title' => $this->titles[$i],
                'parent_id' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
