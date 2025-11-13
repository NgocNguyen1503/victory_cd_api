<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'products.id',
                'products.name',
                'products.thumbnail_url',
                'products.price',
                'products.description',
                'products.score',
                'products.category_id',
                'products.total_sold',
                'products.quantity',
                'categories.title as category_title'
            )->leftJoin('categories', 'categories.id', '=', 'products.category_id')
                ->where('products.id', $param['product_id'])
                ->first();
            $similar_products = Product::select('id', 'name', 'thumbnail_url', 'price', 'score')
                ->where('category_id', $product->category_id)
                ->where('id', '<>', $product->id)
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();
            $product_feedbacks = DB::table('products')
                ->join('bill_details', 'bill_details.product_id', '=', 'products.id')
                ->join('bills', 'bills.id', '=', 'bill_details.bill_id')
                ->join('feedbacks', 'feedbacks.bill_id', '=', 'bills.id')
                ->join('users', 'users.id', '=', 'feedbacks.user_id')
                ->where('products.id', $param['product_id'])
                ->where('feedbacks.type', 0) // chỉ lấy loại đánh giá
                ->where('feedbacks.status', 1) // đã duyệt
                ->select(
                    'feedbacks.id',
                    'feedbacks.comment',
                    'feedbacks.score',
                    'feedbacks.created_at',
                    'users.name as user_name',
                    'users.avatar as user_avatar'
                )
                ->orderBy('feedbacks.id', 'desc')
                ->get();
            $feedback_count = $product_feedbacks->count();
            return ApiResponse::success(compact('product', 'similar_products', 'product_feedbacks', 'feedback_count'));
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }
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
