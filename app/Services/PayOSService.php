<?php

namespace App\Services;

use App\Models\Bill;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use PayOS\PayOS;

class PayOSService
{
    private $payOS;

    /**
     * Constructor method to init PayOS config
     */
    public function __construct()
    {
        Log::info("payos_keys", [
            'client_id' => env('PAYOS_CLIENT_ID'),
            'api_key' => env('PAYOS_API_KEY'),
            'checksum_key' => env('PAYOS_CHECKSUM_KEY')
        ]);

        $this->payOS = new PayOS(
            env('PAYOS_CLIENT_ID'),
            env('PAYOS_API_KEY'),
            env('PAYOS_CHECKSUM_KEY')
        );
    }

    public static function createPaymentLink(Bill $bill, $items)
    {
        $self = new self;

        try {
            $data = [
                'orderCode' => $bill->order_code,
                'amount' => $bill->total_price,
                'description' => "Thanh toán hóa đơn {$bill->order_code}",
                'items' => $items,
                'returnUrl' => 'http://localhost:5173/profile?tab=orders',
                'cancelUrl' => 'http://localhost:5173/home',
                'expiredAt' => Carbon::now()->addMinutes(10)->timestamp
            ];

            Log::info('payos_payload', $data);

            $result = $self->payOS->createPaymentLink($data);

            Log::info('payos_response', $result);

            return $result;

        } catch (\Throwable $th) {
            Log::error('payos_exception', ['msg' => $th->getMessage()]);
            return null;
        }
    }

    public static function getPaymentStatus($orderCode)
    {
        $self = new self;

        try {
            $response = $self->payOS->getPaymentLinkInformation($orderCode);

            Log::info("payos_status", $response);

            return $response;

        } catch (\Throwable $th) {
            Log::error("payos_status_error", [$th->getMessage()]);
            return null;
        }
    }
}