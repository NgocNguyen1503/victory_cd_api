<?php

namespace Database\Seeders;

use App\Helpers\FileHelper;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    private $names = [
        'FeyD',
        'HieuPham',
        'SangPTS',
    ];

    private $emails = [
        'feyd153@gmail.com',
        'tomnguyenhieu2004@gmail.com',
        'phamthesang1307@gmail.com',
    ];

    private $phones = [
        '0901234567',
        '0912345678',
        '0923456789',
    ];

    private $addresses = [
        'Hanoi, Vietnam',
        'Ho Chi Minh City, Vietnam',
        'Da Nang, Vietnam',
    ];

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < count($this->names); $i++) {
            $user = new User;
            $user->email = $this->emails[$i];

            DB::table('users')->insert([
                'name' => $this->names[$i],
                'email' => $this->emails[$i],
                'password' => Hash::make('12345678'),
                'avatar' => env('APP_URL') . '/uploads/avatars' . '/' . FileHelper::getNameFromEmail($user) . '.jpg',
                'phone' => $this->phones[$i],
                'address' => $this->addresses[$i],
                'email_verified_at' => Carbon::now(),
                'role' => fake()->numberBetween(0, 1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
