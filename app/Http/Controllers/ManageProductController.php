<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ManageProductController extends Controller
{
    // Function get all products
    public function listProduct(Request $request)
    {
        $params = $request->all();

        try {
            $query = Product::select(
                'id',
                'name',
                'thumbnail_url',
                'price',
                'score',
                'total_sold',
                'category_id',
                'created_at'
            );

            // sort by param sort_type
            switch ($params['sort_type'] ?? 'default') {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'featured':
                    $query->orderBy('total_sold', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'asc');
                    break;
            }

            $list_products = $query
                ->limit(Product::LIMIT_PRODUCT)
                ->offset($params['offset'] ?? 0)
                ->get();

            return ApiResponse::success(compact('list_products'));
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }
    // Function get best 4 products
    public function bestProducts(Request $request)
    {
        try {
            $best_products = Product::select('id', 'name', 'thumbnail_url', 'price', 'score', 'total_sold', 'description')
                ->orderBy('total_sold', 'desc')
                ->limit(4)
                ->get();
            return ApiResponse::success(compact('best_products'));
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }
    // Function get product detail with feedback
    public function productDetail(Request $request)
    {
        $param = $request->all();
        try {
            $product = Product::select(
                'id',
                'name',
                'thumbnail_url',
                'price',
                'description',
                'score',
                'category_id',
                'total_sold',
                'quantity'
            )->where('id', $param['product_id'])
                ->first();
            $similar_products = Product::select('id', 'name', 'thumbnail_url', 'price', 'score')
                ->where('category_id', $product->category_id)
                ->where('id', '<>', $product->id)
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();
            return ApiResponse::success(compact('product', 'similar_products'));
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }
    // feedbacks(type=0, status=1)->join(bills)->join(bill_details)->where(product_id = $param['product_id'])->get()
    // TODO: thêm phần đánh giá của sản phẩm

    public function similarProduct(Request $request)
    {
        $param = $request->all();

        try {
            // Lấy ra sản phẩm hiện tại để biết category_id
            $product = Product::select('id', 'category_id')
                ->where('id', $param['product_id'])
                ->first();

            // if (!$product) {
            //     return ApiResponse::notFound('Không tìm thấy sản phẩm');
            // }

            // Lấy ra 5 sản phẩm cùng danh mục (loại trừ chính nó)
            $similar_products = Product::select('id', 'name', 'thumbnail_url', 'price', 'score')
                ->where('category_id', $product->category_id)
                ->where('id', '<>', $product->id)
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();

            return ApiResponse::success(compact('similar_products'));
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }
}
