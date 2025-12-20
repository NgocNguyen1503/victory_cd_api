<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (!Auth::attempt($validated)) {
                return ApiResponse::dataNotfound('User not found. Please check your information.');
            }
            $user = Auth::user();
            $token = $user->createToken($user->email)->plainTextToken;

            return ApiResponse::success(compact('user', 'token'));
        } catch (\Throwable $th) {
            Log::error($th);

            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function signup(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8', 'confirmed'],
                'password_confirmation' => ['required']
            ]);

            if (User::where('email', $validated['email'])->first() != null) {
                return ApiResponse::forbidden("This email is already associated with an account.");
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 1
            ]);

            return ApiResponse::success(compact('user'));
        } catch (\Throwable $th) {
            Log::error($th);

            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            if (!is_null($request->header('Authorization'))) {
                return ApiResponse::success();
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::internalServerError($th->getMessage());
        }
    }
}
