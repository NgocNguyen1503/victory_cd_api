<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManageCategoryController extends Controller
{
    public function listCategory()
    {
        try {
            $categories = Category::with([
                'children' => function ($query) {
                    $query->whereNull('deleted_at')
                        ->select('id', 'title', 'parent_id', 'thumbnail_url')
                        ->with([
                            'children' => function ($query) {
                                $query->whereNull('deleted_at')
                                    ->select('id', 'title', 'parent_id', 'thumbnail_url');
                            }
                        ]);
                }
            ])
                ->where('parent_id', 0)
                ->whereNull('deleted_at')
                ->select('id', 'title', 'parent_id', 'thumbnail_url')
                ->get();

            return ApiResponse::success(compact('categories'));
        } catch (\Throwable $th) {
            Log::error($th);
            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function updateOrCreateCate(Request $request)
    {
        $params = $request->all();
        $now = Carbon::now();
        if (Auth::user()->role == 0) {
            try {
                $category = Category::updateOrCreate(
                    [
                        'title' => $params['title'],
                        'parent_id' => $params['parent_id'],
                    ],
                    [
                        'thumbnail_url' => env('APP_URL') . '/uploads/products/thumbnail_urls/' . $params['title'] . '.jpg',
                        'updated_at' => $now,
                    ]
                );
            } catch (\Throwable $th) {
                Log::error($th);
                return ApiResponse::internalServerError($th->getMessage());
            }
        } else {
            return ApiResponse::forbidden("Chỉ admin mới có quyền chỉnh sửa dữ liệu!");
        }
    }

    public function deleteCate(Request $request)
    {
        $params = $request->all();
        $now = Carbon::now();
        if (Auth::user()->role == 0) {
            try {
                DB::table('categories')->where('id', $params['category_id'])
                    ->update(['deleted_at' => $now]);
            } catch (\Throwable $th) {
                Log::error($th);
                return ApiResponse::internalServerError($th->getMessage());
            }
        } else {
            return ApiResponse::forbidden("Chỉ admin mới có quyền xoá!");
        }
    }
}
