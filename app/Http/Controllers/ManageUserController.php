<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Auth;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class ManageUserController extends Controller
{
    public function userInfor(Request $request)
    {
        try {
            $user = Auth::user();
            return ApiResponse::success($user);
        } catch (\Throwable $th) {
            return ApiResponse::dataNotfound();
        }
    }
}
