<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    // Function feedback sản phẩm
    public function sendFeedback(Request $request)
    {
        $request->validate([
            'bill_id' => 'required|exists:bills,id',
            'score'   => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        try {
            $userId = Auth::id(); // Lấy ID user đang đăng nhập

            // 1. Kiểm tra xem user đã đánh giá đơn này chưa
            $exists = DB::table('feedbacks')
                ->where('user_id', $userId)
                ->where('bill_id', $request->bill_id)
                ->where('type', 0) // 0 là rate
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Bạn đã đánh giá đơn hàng này rồi.'], 400);
            }

            // 2. Thêm đánh giá vào bảng feedbacks
            DB::table('feedbacks')->insert([
                'type'       => 0,
                'bill_id'    => $request->bill_id,
                'user_id'    => $userId,
                'score'      => $request->score,
                'comment'    => $request->comment,
                'status'     => 1, // Mặc định hiện
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Gửi đánh giá thành công!'], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Lỗi hệ thống', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
