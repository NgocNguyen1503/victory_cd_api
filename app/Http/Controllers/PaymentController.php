<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Product;
use App\Services\PayOSService;
use Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createBill(Request $request)
    {
        $params = $request->all();

        try {
            $bill = Bill::create([
                'user_id' => Auth::id(),
                'order_code' => intval(substr(strval(microtime(true) * 10000), -6)),
                'payment_method' => $params['payment_method'] === 'online' ? Bill::PAYMENT_METHOD_ONLINE : Bill::PAYMENT_METHOD_OFFLINE,
                'total_price' => (double) $params['total_price'],
                'phone' => $params['phone'],
                'address' => $params['address'],
            ]);

            $products = [];
            foreach ($params['items'] as $item) {
                BillDetail::create([
                    'bill_id' => $bill->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total_price'],
                ]);

                array_push($products, [
                    'name' => Product::where('id', $item['id'])->value('name'),
                    'quantity' => $item['quantity'],
                    'price' => (double) $item['price']
                ]);
            }

            if ($bill->payment_method == Bill::PAYMENT_METHOD_ONLINE) {
                $bill->status = 1;
                $bill->save();
                \Log::info('payload_payos', [
                    'bill' => $bill,
                    'products' => $products
                ]);
                $res = PayOSService::createPaymentLink($bill, $products);

                if (!is_null($res)) {
                    $bill->checkout_url = $res['checkoutUrl'];
                    return ApiResponse::success(compact('bill'));
                }

                return ApiResponse::internalServerError("Không thể tạo link thanh toán online");
            } else {
                $bill->status = 4;
                $bill->save();
            }

            return ApiResponse::success(compact('bill'));
        } catch (\Throwable $th) {
            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function checkPaymentStatus(Request $request)
    {
        $orderCode = $request->orderCode;

        if (!$orderCode) {
            return ApiResponse::badRequest();
        }

        $data = PayOSService::getPaymentStatus($orderCode);

        if (!$data) {
            return ApiResponse::internalServerError();
        }

        $bill = Bill::where('order_code', $orderCode)->first();
        if ($bill) {
            switch ($data['status']) {
                case 'PAID':
                    $bill->status = 3;
                    break;
                case 'PENDING':
                    $bill->status = 2;
                    break;
                case 'PROCESSING':
                    $bill->status = 1;
                    break;
                case 'FAILED':
                default:
                    $bill->status = 0;
                    break;
            }
            $bill->save();
        }

        return ApiResponse::success($data);
    }
}
