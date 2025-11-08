<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ManageProductController extends Controller
{
    public function listProduct(Request $request)
    {
        try {
            $products = Product::select('id', 'name', 'thumbnail_url', 'price', 'score')->get();

            return ApiResponse::success(compact('products'));
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }
    // public function bestProduct(Request $request)
    // {
    //     try {
            
    //     } catch (\Throwable $th) {
    //         Log::error($th);
    //         return ApiResponse::internalServerError($th->getMessage());
    //     }
    // }
}
