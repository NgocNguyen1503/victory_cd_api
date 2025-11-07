<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\User;
use App\Services\GoogleAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function __construct(private GoogleAuthService $googleAuthService)
    {
    }

    public function redirect(Request $request)
    {
        $params = $request->all();
        if (!isset($params['from']) || blank($params['from'])) {
            return ApiResponse::forbidden();
        }
        Cache::put('from', $params['from']);

        if (!isset($params['state']) || blank($params['state'])) {
            return ApiResponse::forbidden();
        }
        $state = $params['state'];
        $url = $this->googleAuthService->getOAuthUrl($state);

        return ApiResponse::success($url);
    }

    public function callback(Request $request)
    {
        $params = $request->all();
        try {
            $accessToken = $this->googleAuthService->getAccessToken($params['code']);
            $userInfo = $this->googleAuthService->getUserInfo($accessToken);

            $user = User::createOrFirst(['email' => $userInfo['email']], [
                'name' => $userInfo['name'],
                'email' => $userInfo['email'],
                'avatar' => $userInfo['picture'],
                'role' => 1,
            ]);

            $token = $user->createToken($user->email)->plainTextToken;

            if (isset($params['state']) && !blank($params['state'])) {
                Cache::put($params['state'], $token, now()->addDay());
            }

            $from = null;
            if (Cache::has('from')) {
                $from = Cache::get('from');
            }

            return match ($from) {
                'web' => redirect()->away(env('CLIENT_APP_URL') . "/login?code=$token"),
                'mobile' => redirect()->away(env('CLIENT_APP_URL') . "/success"),
                default => redirect()->away(env('CLIENT_APP_URL') . "/login"),
            };
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return ApiResponse::internalServerError();
        }
    }

    public function getToken(Request $request)
    {
        $params = $request->all();
        if (!Cache::has($params['state'])) {
            return ApiResponse::forbidden();
        }
        return ApiResponse::success(Cache::get($params['state']));
    }
}
