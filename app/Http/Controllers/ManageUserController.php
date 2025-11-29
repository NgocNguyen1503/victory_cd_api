<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ManageUserController extends Controller
{
    public function userInfor(Request $request)
    {
        try {
            $user = Auth::user();
            return ApiResponse::success($user);
        } catch (\Throwable $th) {
            return ApiResponse::dataNotfound();
        }
    }
    
    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return ApiResponse::unauthorized('Bạn chưa đăng nhập.');
            }

            // Validate cơ bản (không validate mật khẩu)
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            // Cập nhật thông tin cơ bản
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;

            // Xử lý thay đổi mật khẩu nếu có nhập
            if ($request->filled('current_password') || $request->filled('new_password')) {

                // Check nhập đủ 3 trường
                if (!$request->filled('current_password') || !$request->filled('new_password') || !$request->filled('new_password_confirmation')) {
                    return ApiResponse::unprocessableContent(null, 'Vui lòng nhập đầy đủ mật khẩu.');
                }

                // Check mật khẩu hiện tại
                if (!Hash::check($request->current_password, $user->password)) {
                    return ApiResponse::unprocessableContent(null, 'Mật khẩu hiện tại không đúng.');
                }

                // Check mật khẩu mới khớp nhau
                if ($request->new_password !== $request->new_password_confirmation) {
                    return ApiResponse::unprocessableContent(null, 'Xác nhận mật khẩu mới không khớp.');
                }

                // Check độ dài
                if (strlen($request->new_password) < 8) {
                    return ApiResponse::unprocessableContent(null, 'Mật khẩu mới phải ít nhất 8 ký tự.');
                }

                // Lưu mật khẩu mới
                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            return ApiResponse::success(['user' => $user], 'Cập nhật thông tin thành công.');

        } catch (\Illuminate\Validation\ValidationException $ve) {
            return ApiResponse::unprocessableContent($ve->errors(), 'Dữ liệu không hợp lệ.');
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function orderHistory(Request $request)
    {
        $userId = $request->user()->id;
        
        try {
            // 1. ĐƠN HÀNG CHUẨN BỊ (3,4)
            $orderPreparing = DB::table('bills')
                ->join('bill_details', 'bill_details.bill_id', '=', 'bills.id')
                ->join('products', 'products.id', '=', 'bill_details.product_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where('bills.user_id', $userId)
                ->whereIn('bills.status', [3, 4])
                ->select(
                    'bills.id as bill_id',
                    'bills.order_code as bill_code',
                    'bills.status as bill_status',
                    'bills.total_price as bill_total_price',

                    'bill_details.quantity as detail_quantity',
                    'bill_details.total_price as detail_total_price',

                    'products.id as product_id',
                    'products.name as product_name',
                    'products.thumbnail_url as product_thumbnail',
                    'products.price as product_price',

                    'categories.id as category_id',
                    'categories.title as category_title',
                    'categories.thumbnail_url as category_thumbnail'
                )
                ->orderBy('bills.id', 'desc')
                ->get();

            // 2. ĐƠN ĐANG GIAO (5)
            $orderShipping = DB::table('bills')
                ->join('bill_details', 'bill_details.bill_id', '=', 'bills.id')
                ->join('products', 'products.id', '=', 'bill_details.product_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where('bills.user_id', $userId)
                ->where('bills.status', 5)
                ->select(
                    'bills.id as bill_id',
                    'bills.order_code as bill_code',
                    'bills.status as bill_status',
                    'bills.total_price as bill_total_price',

                    'bill_details.quantity as detail_quantity',
                    'bill_details.total_price as detail_total_price',

                    'products.id as product_id',
                    'products.name as product_name',
                    'products.thumbnail_url as product_thumbnail',
                    'products.price as product_price',

                    'categories.id as category_id',
                    'categories.title as category_title',
                    'categories.thumbnail_url as category_thumbnail'
                )
                ->orderBy('bills.id', 'desc')
                ->get();

            // 3. ĐƠN HOÀN THÀNH (6)
            $orderCompleted = DB::table('bills')
                ->join('bill_details', 'bill_details.bill_id', '=', 'bills.id')
                ->join('products', 'products.id', '=', 'bill_details.product_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where('bills.user_id', $userId)
                ->where('bills.status', 6)
                ->select(
                    'bills.id as bill_id',
                    'bills.order_code as bill_code',
                    'bills.status as bill_status',
                    'bills.total_price as bill_total_price',

                    'bill_details.quantity as detail_quantity',
                    'bill_details.total_price as detail_total_price',

                    'products.id as product_id',
                    'products.name as product_name',
                    'products.thumbnail_url as product_thumbnail',
                    'products.price as product_price',

                    'categories.id as category_id',
                    'categories.title as category_title',
                    'categories.thumbnail_url as category_thumbnail'
                )
                ->orderBy('bills.id', 'desc')
                ->get();


            return ApiResponse::success(compact(
                'orderPreparing',
                'orderShipping',
                'orderCompleted'
            ));

        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }
}
