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

    public function getMonthlyRevenue()
    {
        try {
            // Lấy dữ liệu 12 tháng gần nhất
            $revenues = DB::table('bills')
                ->where('status', 6) // Chỉ tính các đơn đã hoàn thành
                ->select(
                    DB::raw('SUM(total_price) as total'),
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('YEAR(created_at) as year')
                )
                ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            // Chuẩn hóa dữ liệu để luôn đủ 12 tháng (kể cả tháng doanh thu bằng 0)
            $data = [];
            for ($i = 11; $i >= 0; $i--) {
                $month = now()->subMonths($i)->format('m');
                $year = now()->subMonths($i)->format('Y');
                
                $found = $revenues->where('month', (int)$month)->where('year', (int)$year)->first();
                
                $data[] = [
                    'label' => "Tháng $month/$year",
                    'total' => $found ? (float)$found->total : 0
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
