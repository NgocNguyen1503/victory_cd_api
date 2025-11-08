<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class FirebaseAuthController extends Controller
{
    public function signin(Request $request)
    {
        try {
            $params = $request->all();
            $user = User::firstOrCreate(['email' => $params['email']], [
                'name' => $params['name'] ?? "Người dùng " . User::count() + 1,
                'email' => $params['email'],
                'password' => Hash::make("12345678"),
                'role' => 1,
                'avatar' => $params['avatar'] ?? null,
                'address' => $params['address'] ?? 'Việt Nam',
                'phone' => $params['phone'] ?? null
            ]);
            $token = $user->createToken($user->email)->plainTextToken;

            return ApiResponse::success(compact('user', 'token'));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ApiResponse::internalServerError($th->getMessage());
        }
    }
}
