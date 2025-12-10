<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BillDetailSeeder extends Seeder
{
    public function run(): void
    {
        $bills = DB::table('bills')->pluck('id');
        $products = DB::table('products')->pluck('id');

        foreach ($bills as $bill_id) {
            // Mỗi đơn có 1–3 sản phẩm
            $numItems = rand(1, 3);
            $productSample = $products->random($numItems);

            foreach ($productSample as $product_id) {
                $quantity = rand(1, 3);
                $price = DB::table('products')->where('id', $product_id)->value('price');
                $total = $price * $quantity;

                DB::table('bill_details')->insert([
                    'bill_id' => $bill_id,
                    'product_id' => fake()->numberBetween(1, 10),
                    'quantity' => $quantity,
                    'total_price' => $total,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
