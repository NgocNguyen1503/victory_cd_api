<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageOrderController extends Controller
{
    // Lấy danh sách đơn hàng 
    public function listOrder()
    {
        $orders = DB::table('bills')
            ->join('users', 'users.id', '=', 'bills.user_id')
            ->join('bill_details', 'bill_details.bill_id', '=', 'bills.id')
            ->join('products', 'products.id', '=', 'bill_details.product_id')
            ->whereIn('bills.status', [4,5,6])
            ->select(
                'bills.id',
                'bills.order_code',
                'bills.user_id',
                'bills.status',
                'bills.created_at',
                'bills.total_price',
                'users.name as user_name',

                'products.id as product_id',
                'products.name as product_name',
                'bill_details.quantity'
            )
            ->orderBy('bills.created_at', 'desc')
            ->get();

        /**
         * Gom dữ liệu theo bill
         */
        $bills = [];

        foreach ($orders as $order) {

            if (!isset($bills[$order->id])) {
                $bills[$order->id] = [
                    'id' => $order->id,
                    'order_code' => $order->order_code,
                    'user_id' => $order->user_id,
                    'user_name' => $order->user_name,
                    'status' => $order->status,
                    'created_at' => $order->created_at,
                    'total_price' => $order->total_price,
                    'products' => []
                ];
            }

            $bills[$order->id]['products'][] = [
                'product_id' => $order->product_id,
                'product_name' => $order->product_name,
                'quantity' => $order->quantity
            ];
        }

        return response()->json([
            'data' => array_values($bills)
        ]);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateOrderStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:bills,id',
            'status' => 'required|in:3,4,5,6'
        ]);

        try {
            DB::table('bills')
                ->where('id', $request->order_id)
                ->update([
                    'status' => $request->status,
                    'updated_at' => now()
                ]);

            return response()->json([
                'message' => 'Cập nhật trạng thái đơn hàng thành công'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Cập nhật trạng thái thất bại',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
