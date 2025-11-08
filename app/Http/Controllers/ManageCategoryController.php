<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ManageCategoryController extends Controller
{
    public function listCategory()
    {
        try {
            $categories = Category::with(['children' => function ($query) {
                $query->whereNull('deleted_at')
                    ->select('id', 'title', 'parent_id', 'thumbnail_url')
                    ->with(['children' => function ($query) {
                        $query->whereNull('deleted_at')
                            ->select('id', 'title', 'parent_id', 'thumbnail_url');
                    }]);
            }])
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
}
