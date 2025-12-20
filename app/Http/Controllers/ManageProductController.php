<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
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
                'created_at',
                'quantity',
                'description'
            );

            // filter by category
            if (!empty($params['category_id'])) {
                $categoryId = $params['category_id'];
                $category = Category::find($categoryId);

                if ($category) {
                    if ($category->parent_id == 0) {
                        $childIds = Category::where('parent_id', $categoryId)->pluck('id')->toArray();
                        $childIds[] = $categoryId;
                        $query->whereIn('category_id', $childIds);
                    } else {
                        $query->where('category_id', $categoryId);
                    }
                }
            }

            // filter by search key
            if (!empty($params['search_key'])) {
                $searchKey = $params['search_key'];
                $query->where('name', 'like', "%{$searchKey}%");
            }

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

    // Function update or create product
    public function updateOrCreateProduct(Request $request)
    {
        $params = $request->all();
        $now = Carbon::now();

        // Chỉ admin mới được phép thao tác
        if (Auth::user()->role == 0) {
            try {
                // Tạo hoặc cập nhật sản phẩm
                $product = Product::updateOrCreate(
                    [
                        'name' => $params['name'],
                        'category_id' => $params['category_id'],
                    ],
                    [
                        'description' => $params['description'] ?? null,
                        'brand' => $params['brand'] ?? null,
                        'price' => $params['price'] ?? 0,
                        'quantity' => $params['quantity'] ?? 0,
                        'total_sold' => $params['total_sold'] ?? 0,
                        'score' => $params['score'] ?? 0,
                        'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $params['name'] . '.jpg',
                        'updated_at' => $now,
                    ]
                );

                return ApiResponse::success($product, "Cập nhật sản phẩm thành công!");
            } catch (\Throwable $th) {
                Log::error($th);
                return ApiResponse::internalServerError($th->getMessage());
            }
        } else {
            return ApiResponse::forbidden("Chỉ admin mới có quyền chỉnh sửa dữ liệu!");
        }
    }

    // Function delele product
    public function deleteProduct(Request $request)
    {
        $params = $request->all();
        $now = Carbon::now();

        if (Auth::user()->role == 0) {
            try {
                DB::table('products')
                    ->where('id', $params['product_id'])
                    ->update(['deleted_at' => $now]);

                return ApiResponse::success(null, "Xóa sản phẩm thành công!");
            } catch (\Throwable $th) {
                Log::error($th);
                return ApiResponse::internalServerError($th->getMessage());
            }
        } else {
            return ApiResponse::forbidden("Chỉ admin mới có quyền xoá!");
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
        $productId = $request->product_id;
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
            $product_feedbacks = DB::table('feedbacks')
                ->join('users', 'users.id', '=', 'feedbacks.user_id')
                ->join('bills', 'bills.id', '=', 'feedbacks.bill_id')
                ->join('bill_details', 'bill_details.bill_id', '=', 'bills.id')
                ->where('bill_details.product_id', $productId) // Lọc theo sản phẩm hiện tại
                ->where('feedbacks.type', 0)    // 0 = Rate
                ->where('feedbacks.status', 1)  // 1 = Active
                ->select(
                    'feedbacks.id',
                    'feedbacks.comment',
                    'feedbacks.score',
                    'feedbacks.created_at',
                    'users.name as user_name',
                    'users.avatar as user_avatar' // Đảm bảo bảng users có cột avatar, nếu không thì bỏ dòng này
                )
                ->distinct() // Tránh trùng lặp nếu 1 bill có 2 dòng sản phẩm giống nhau (hiếm nhưng có thể)
                ->orderBy('feedbacks.created_at', 'desc')
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
