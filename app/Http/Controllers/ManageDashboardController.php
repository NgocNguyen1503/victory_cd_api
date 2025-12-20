<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageDashboardController extends Controller
{
    /** Function get some infomations about shop */
    public function getStatistics(Request $request)
    {
        try {
            $countCustomers = DB::table('users')
                ->where('role', 1)
                ->count();
            $countProducts = DB::table('products')
                ->count();
            $countOrders = DB::table('bills')
                ->whereIn('status', [
                    Bill::STATUS_PREPARING,
                    Bill::STATUS_SHIPPING,
                    Bill::STATUS_DONE
                ])->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();
            return response()->json([
                'success' => true,
                'data' => [
                    'count_customers' => $countCustomers,
                    'count_products' => $countProducts,
                    'count_orders' => $countOrders,
                ],
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics.',
            ], 500);
        }
    }

    /** Function get revenue by year */
    public function getRevenueByYear(Request $request)
    {
        try {
            $revenueByYear = Bill::select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total) as total'))
                ->where('status', Bill::STATUS_DONE)
                ->groupBy('year')
                ->get();
            return response()->json([
                'success' => true,
                'data' => $revenueByYear,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve statistics.',
            ], 500);
        }
    }
}
